<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassBooking;
use App\Models\Class\ClassSchedule;
use App\Models\User;
use App\Models\UserPackage;
use App\Notifications\MemberCheckedInNotification;
use App\Notifications\WaitingPromotedNotification;
use App\Services\MembershipService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ClassBookingController extends Controller
{
    /**
     * QR scan page for admin front-desk check-in.
     * Member shows the QR from My Bookings; admin scans it here.
     * Laptop = desktop view, HP = phone-frame mobile view.
     */
    public function scan()
    {
        abort_unless(Auth::user()->hasAnyRole(['super-admin', 'admin']), 403);

        if (\App\Support\MemberView::isMobile()) {
            return view('pages.mobile.scan');
        }

        return view('pages.class-bookings.scan');
    }

    /**
     * Lookup a booking by uuid for the scan page (admin only, JSON).
     */
    public function lookup(Request $request)
    {
        abort_unless(Auth::user()->hasAnyRole(['super-admin', 'admin']), 403);

        $validated = $request->validate([
            'uuid' => ['required', 'uuid'],
        ]);

        $booking = ClassBooking::with(['user', 'schedule.class', 'schedule.studio'])
            ->where('uuid', $validated['uuid'])
            ->first();

        if (! $booking) {
            Log::warning('Scan lookup: booking not found', [
                'uuid' => $validated['uuid'],
                'by' => Auth::user()?->uuid,
            ]);

            return response()->json(['found' => false, 'uuid' => $validated['uuid']]);
        }

        return response()->json([
            'found' => true,
            'uuid' => $booking->uuid,
            'member' => $booking->user?->name ?? '-',
            'email' => $booking->user?->email ?? '-',
            'class' => $booking->schedule?->class?->name ?? '-',
            'day' => ucfirst($booking->schedule?->day ?? '-'),
            'time' => substr((string) $booking->schedule?->start_time, 0, 5) . '–' . substr((string) $booking->schedule?->end_time, 0, 5),
            'date' => $booking->booking_date?->format('d M Y') ?? '-',
            'status' => $booking->status,
            'is_today' => $booking->booking_date?->format('Y-m-d') === now()->format('Y-m-d'),
            'checkin_url' => route('class-bookings.checkin', $booking->uuid),
        ]);
    }

    /**
     * List class bookings (all for admin, own for members).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);

        // Member selalu ke versi mobile phone-frame (satu halaman bookings).
        if (! $isAdmin) {
            return redirect()->route('bookings.my');
        }

        $query = ClassBooking::with(['user', 'schedule.class', 'schedule.studio']);

        if (!$isAdmin) {
            $query->where('user_uuid', $user->uuid);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->input('date'));
        }

        if ($request->filled('search') && $isAdmin) {
            $search = $request->input('search');

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $bookings = $query
            ->latest('booking_date')
            ->latest('booked_at')
            ->paginate(10)
            ->withQueryString();

        $members = [];
        $schedules = [];

        if ($isAdmin) {
            $members = UserPackage::with('user')
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
                })
                ->where(function ($q) {
                    $q->whereNull('quota')->orWhere('quota', '>', 0);
                })
                ->get()
                ->sortBy(fn ($m) => $m->user?->name ?? '')
                ->values();

            $schedules = ClassSchedule::with('class')
                ->where('status', 'active')
                ->orderByRaw("FIELD(day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
                ->orderBy('start_time')
                ->get();
        }

        return view('pages.class-bookings.index', [
            'bookings' => $bookings,
            'isAdmin' => $isAdmin,
            'members' => $members,
            'schedules' => $schedules,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'date' => $request->input('date'),
            ],
        ]);
    }

    /**
     * Member books a class schedule for a concrete date.
     *
     * Requires an active membership with remaining quota.
     * Full sessions go to the waiting list.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_schedule_uuid' => ['required', 'uuid', 'exists:class_schedules,uuid'],
            'booking_date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addDays(60)->format('Y-m-d')],
            // 1-tap "Book & Check In" khusus jadwal hari ini.
            'checkin' => ['nullable', 'boolean'],
        ]);

        $member = Auth::user();
        $date = Carbon::parse($validated['booking_date'])->format('Y-m-d');
        $wantCheckin = !empty($validated['checkin']) && $date === now()->format('Y-m-d');

        try {
            $result = DB::transaction(function () use ($member, $validated, $date, $wantCheckin) {
                // Kunci baris member: dua request bersamaan (double-tap /
                // dua tab) dari user yang sama diproses berurutan, sehingga
                // tidak bisa lolos cek ganda dan tercipta booking dobel.
                User::where('uuid', $member->uuid)->lockForUpdate()->firstOrFail();

                $schedule = ClassSchedule::where('uuid', $validated['class_schedule_uuid'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($schedule->status !== 'active') {
                    throw ValidationException::withMessages([
                        'schedule' => __('flash.schedule_unavailable'),
                    ]);
                }

                $this->assertDateMatchesSchedule($date, $schedule);

                $package = MembershipService::activePackage($member);

                if (!$package) {
                    throw ValidationException::withMessages([
                        'membership' => __('flash.need_membership'),
                    ]);
                }

                $existing = ClassBooking::where('user_uuid', $member->uuid)
                    ->where('class_schedule_uuid', $schedule->uuid)
                    ->whereDate('booking_date', $date)
                    ->where('status', '!=', 'cancelled')
                    ->first();

                if ($existing) {
                    throw ValidationException::withMessages([
                        'booking' => __('flash.already_booked_date'),
                    ]);
                }

                // Tolak jadwal yang jamnya bentrok di tanggal yang sama
                // (jadwal sama / jadwal lain yang waktunya tumpang tindih).
                $overlap = ClassBooking::where('user_uuid', $member->uuid)
                    ->whereDate('booking_date', $date)
                    ->where('status', '!=', 'cancelled')
                    ->whereHas('schedule', function ($q) use ($schedule) {
                        $q->where('start_time', '<', $schedule->end_time)
                            ->where('end_time', '>', $schedule->start_time);
                    })
                    ->exists();

                if ($overlap) {
                    throw ValidationException::withMessages([
                        'booking' => __('flash.overlap_booking'),
                    ]);
                }

                $status = $this->confirmedCount($schedule, $date) < $schedule->capacity
                    ? 'confirmed'
                    : 'waiting_list';

                // Kelas penuh tidak bisa langsung check-in.
                if ($wantCheckin && $status !== 'confirmed') {
                    $wantCheckin = false;
                }

                $booking = ClassBooking::create([
                    'user_uuid' => $member->uuid,
                    'class_schedule_uuid' => $schedule->uuid,
                    'booking_date' => $date,
                    'booking_type' => 'package',
                    'quota_used' => $wantCheckin ? 1 : 0,
                    'status' => $wantCheckin ? 'attended' : $status,
                    'booked_at' => now(),
                    'attended_at' => $wantCheckin ? now() : null,
                    'package_uuid' => $package->package_uuid,
                    'order_uuid' => $package->order_uuid,
                ]);

                $remaining = $package->quota;

                if ($wantCheckin) {
                    // Kunci & potong kuota dalam transaksi yang sama.
                    $lockedPackage = MembershipService::activePackage($member, true);
                    if (!$lockedPackage) {
                        throw ValidationException::withMessages([
                            'membership' => __('flash.no_quota_checkin'),
                        ]);
                    }
                    if (!is_null($lockedPackage->quota)) {
                        $lockedPackage->decrement('quota');
                        $lockedPackage->refresh();
                    }
                    $remaining = $lockedPackage->quota;
                }

                return ['status' => $wantCheckin ? 'attended' : $status, 'remaining' => $remaining, 'booking' => $booking];
            });
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        if ($result['status'] === 'attended') {
            try {
                $result['booking']->loadMissing(['schedule.class', 'user']);
                $result['booking']->user?->notify(new MemberCheckedInNotification(
                    $result['booking']->schedule?->class?->name ?? 'Class',
                    trim(ucfirst($result['booking']->schedule?->day ?? '') . ' ' . substr((string) $result['booking']->schedule?->start_time, 0, 5)),
                    $result['remaining'],
                    false,
                ));
            } catch (\Throwable $e) {
                Log::error('Check-in notification failed: ' . $e->getMessage());
            }

            return back()->with(
                'success',
                is_null($result['remaining'])
                    ? __('flash.booked_in')
                    : __('flash.booked_in_remain', ['count' => $result['remaining']])
            );
        }

        return back()->with(
            'success',
            $result['status'] === 'confirmed'
                ? __('flash.booked_ok')
                : __('flash.booked_waiting')
        );
    }

    /**
     * Check in a booking (member self or admin).
     *
     * Self check-in only works on the booking day.
     * Quota is consumed here — only members with an active
     * membership can check in.
     */
    public function checkin(Request $request, string $booking)
    {
        $authUser = Auth::user();
        $isAdmin = $authUser->hasAnyRole(['super-admin', 'admin']);

        $booking = ClassBooking::with(['schedule', 'user'])
            ->where('uuid', $booking)
            ->firstOrFail();

        if (!$isAdmin && $booking->user_uuid !== $authUser->uuid) {
            abort(403);
        }

        if ($booking->status === 'attended') {
            return back()->with('error', __('flash.already_checked_in'));
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', __('flash.only_confirmed_checkin'));
        }

        if ($booking->schedule?->status !== 'active') {
            return back()->with('error', __('flash.schedule_unavailable'));
        }

        if ($booking->booking_date?->format('Y-m-d') !== now()->format('Y-m-d') && ! $isAdmin) {
            return back()->with('error', __('flash.checkin_day_only'));
        }

        try {
            $remaining = DB::transaction(function () use ($booking) {
                $fresh = ClassBooking::where('uuid', $booking->uuid)->lockForUpdate()->first();

                if ($fresh->status !== 'confirmed') {
                    throw ValidationException::withMessages([
                        'booking' => __('flash.checkin_stale'),
                    ]);
                }

                $member = User::where('uuid', $fresh->user_uuid)->firstOrFail();
                $package = MembershipService::activePackage($member, true);

                if (!$package) {
                    throw ValidationException::withMessages([
                        'membership' => __('flash.no_quota_checkin'),
                    ]);
                }

                $fresh->update([
                    'status' => 'attended',
                    'attended_at' => now(),
                    'quota_used' => 1,
                    'package_uuid' => $package->package_uuid,
                ]);

                if (!is_null($package->quota)) {
                    $package->decrement('quota');
                    $package->refresh();
                }

                return $package->quota;
            });
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        }

        try {
            $booking->loadMissing(['schedule.class', 'user']);
            $booking->user?->notify(new MemberCheckedInNotification(
                $booking->schedule?->class?->name ?? 'Class',
                trim(ucfirst($booking->schedule?->day ?? '') . ' ' . substr((string) $booking->schedule?->start_time, 0, 5)),
                $remaining,
                $isAdmin && $booking->user_uuid !== $authUser->uuid,
            ));
        } catch (\Throwable $e) {
            Log::error('Check-in notification failed: ' . $e->getMessage());
        }

        return back()->with(
            'success',
            is_null($remaining)
                ? __('flash.checked_in_ok')
                : __('flash.checked_in_remain', ['count' => $remaining])
        );
    }

    /**
     * Cancel a booking (member self or admin).
     *
     * Cancelling a confirmed booking promotes the oldest
     * waiting-list booking of the same session automatically.
     */
    public function cancel(Request $request, string $booking)
    {
        $authUser = Auth::user();
        $isAdmin = $authUser->hasAnyRole(['super-admin', 'admin']);

        $booking = ClassBooking::where('uuid', $booking)->firstOrFail();

        if (!$isAdmin && $booking->user_uuid !== $authUser->uuid) {
            abort(403);
        }

        if (!in_array($booking->status, ['confirmed', 'waiting_list'], true)) {
            return back()->with('error', __('flash.cannot_cancel'));
        }

        // Member tidak bisa cancel booking confirmed < 2 jam sebelum mulai
        // agar slot tidak hangus mendadak. Admin bebas (koreksi).
        if (! $isAdmin && $booking->status === 'confirmed') {
            $booking->loadMissing('schedule');

            $start = $booking->schedule?->start_time
                ? substr((string) $booking->schedule->start_time, 0, 5)
                : null;

            if ($booking->booking_date && $start) {
                $classAt = $booking->booking_date->copy()->setTimeFromTimeString($start);

                if ($classAt->lessThanOrEqualTo(now()->addHours(2))) {
                    return back()->with('error', __('flash.cancel_cutoff'));
                }
            }
        }

        $promotedUuid = null;

        DB::transaction(function () use ($booking, &$promotedUuid) {
            $locked = ClassBooking::where('uuid', $booking->uuid)->lockForUpdate()->first();

            if (!in_array($locked->status, ['confirmed', 'waiting_list'], true)) {
                return;
            }

            $wasConfirmed = $locked->status === 'confirmed';
            $locked->update(['status' => 'cancelled']);

            if ($wasConfirmed) {
                $promoted = ClassBooking::where('class_schedule_uuid', $locked->class_schedule_uuid)
                    ->whereDate('booking_date', $locked->booking_date)
                    ->where('status', 'waiting_list')
                    ->orderBy('booked_at')
                    ->lockForUpdate()
                    ->first();

                if ($promoted) {
                    $promoted->update(['status' => 'confirmed']);
                    $promotedUuid = $promoted->uuid;
                }
            }
        });

        // Notify the member promoted from the waiting list, if any.
        if ($promotedUuid) {
            try {
                $promotedBooking = ClassBooking::with(['user', 'schedule.class'])
                    ->where('uuid', $promotedUuid)
                    ->first();

                $promotedBooking?->user?->notify(new WaitingPromotedNotification(
                    $promotedBooking->schedule?->class?->name ?? 'Class',
                    trim(ucfirst($promotedBooking->schedule?->day ?? '') . ' ' . substr((string) $promotedBooking->schedule?->start_time, 0, 5)),
                    $promotedBooking->booking_date?->format('d M Y') ?? '-',
                ));
            } catch (\Throwable $e) {
                Log::error('Waiting promotion notification failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', __('flash.cancel_ok'));
    }

    /**
     * Member can rate a class they attended.
     */
    public function rate(Request $request, string $booking)
    {
        $user = Auth::user();
        abort_unless($user->hasRole('user'), 403);

        $bookingModel = ClassBooking::where('uuid', $booking)
            ->where('user_uuid', $user->uuid)
            ->firstOrFail();

        abort_unless($bookingModel->status === 'attended', 403, 'You can only rate classes you attended.');
        abort_if(!is_null($bookingModel->rating), 403, 'You have already rated this class.');

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'rating_comment' => ['nullable', 'string', 'max:500'],
        ]);

        $bookingModel->update([
            'rating' => $validated['rating'],
            'rating_comment' => $validated['rating_comment'] ?? null,
        ]);

        return back()->with('success', __('flash.rate_ok'));
    }

    /**
     * Admin direct check-in for a member (e.g. member attended
     * but did not check in via the system). Consumes quota so
     * records stay in sync. Past dates (up to 90 days back)
     * are allowed for corrections.
     */
    public function directCheckin(Request $request)
    {
        abort_unless(
            Auth::user()->hasAnyRole(['super-admin', 'admin']),
            403
        );

        $validated = $request->validate([
            'user_uuid' => ['required', 'uuid', 'exists:users,uuid'],
            'class_schedule_uuid' => ['required', 'uuid', 'exists:class_schedules,uuid'],
            'booking_date' => [
                'required', 'date',
                'after_or_equal:' . now()->subDays(90)->format('Y-m-d'),
                'before_or_equal:' . now()->format('Y-m-d'),
            ],
        ]);

        $member = User::where('uuid', $validated['user_uuid'])->firstOrFail();
        $schedule = ClassSchedule::where('uuid', $validated['class_schedule_uuid'])->firstOrFail();
        $date = Carbon::parse($validated['booking_date'])->format('Y-m-d');

        if ($schedule->status !== 'active') {
            return back()->with('error', __('flash.schedule_unavailable'));
        }

        try {
            $this->assertDateMatchesSchedule($date, $schedule);
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        try {
            $remaining = DB::transaction(function () use ($member, $schedule, $date) {
                $package = MembershipService::activePackage($member, true);

                if (!$package) {
                    throw ValidationException::withMessages([
                        'membership' => $member->name . ' has no active membership with remaining quota.',
                    ]);
                }

                $booking = ClassBooking::where('user_uuid', $member->uuid)
                    ->where('class_schedule_uuid', $schedule->uuid)
                    ->whereDate('booking_date', $date)
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('booked_at')
                    ->lockForUpdate()
                    ->first();

                if ($booking) {
                    if ($booking->status === 'attended') {
                        throw ValidationException::withMessages([
                            'booking' => $member->name . ' is already checked in.',
                        ]);
                    }

                    $booking->update([
                        'status' => 'attended',
                        'attended_at' => now(),
                        'quota_used' => 1,
                        'package_uuid' => $package->package_uuid,
                    ]);
                } else {
                    ClassBooking::create([
                        'user_uuid' => $member->uuid,
                        'class_schedule_uuid' => $schedule->uuid,
                        'booking_date' => $date,
                        'booking_type' => 'package',
                        'quota_used' => 1,
                        'status' => 'attended',
                        'booked_at' => now(),
                        'attended_at' => now(),
                        'package_uuid' => $package->package_uuid,
                        'order_uuid' => $package->order_uuid,
                    ]);
                }

                if (!is_null($package->quota)) {
                    $package->decrement('quota');
                    $package->refresh();
                }

                return $package->quota;
            });
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        try {
            $schedule->loadMissing('class');
            $member->notify(new MemberCheckedInNotification(
                $schedule->class?->name ?? 'Class',
                trim(ucfirst($schedule->day ?? '') . ' ' . substr((string) $schedule->start_time, 0, 5)),
                $remaining,
                true,
            ));
        } catch (\Throwable $e) {
            Log::error('Check-in notification failed: ' . $e->getMessage());
        }

        return back()->with(
            'success',
            is_null($remaining)
                ? __('flash.member_checked_in', ['name' => $member->name])
                : __('flash.member_checked_in_remain', ['name' => $member->name, 'count' => $remaining])
        );
    }

    /**
     * Seats already taken for one session (confirmed + attended).
     */
    private function confirmedCount(ClassSchedule $schedule, string $date): int
    {
        return $schedule->bookings()
            ->whereDate('booking_date', $date)
            ->whereIn('status', ['confirmed', 'attended'])
            ->count();
    }

    /**
     * The booked date must fall on the schedule's weekday.
     */
    private function assertDateMatchesSchedule(string $date, ClassSchedule $schedule): void
    {
        $weekday = strtolower(Carbon::parse($date)->format('l'));

        if ($weekday !== strtolower((string) $schedule->day)) {
            throw ValidationException::withMessages([
                'booking_date' => __('flash.only_runs_on', ['day' => ucfirst(__('mobile.day.' . strtolower((string) $schedule->day)))]),
            ]);
        }
    }
}

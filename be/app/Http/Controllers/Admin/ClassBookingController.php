<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassBooking;
use App\Models\Class\ClassSchedule;
use App\Models\User;
use App\Models\UserPackage;
use App\Notifications\MemberCheckedInNotification;
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
     * List class bookings (all for admin, own for members).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);

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
        ]);

        $member = Auth::user();
        $date = Carbon::parse($validated['booking_date'])->format('Y-m-d');

        try {
            $status = DB::transaction(function () use ($member, $validated, $date) {
                $schedule = ClassSchedule::where('uuid', $validated['class_schedule_uuid'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($schedule->status !== 'active') {
                    throw ValidationException::withMessages([
                        'schedule' => 'This class schedule is not available.',
                    ]);
                }

                $this->assertDateMatchesSchedule($date, $schedule);

                $package = MembershipService::activePackage($member);

                if (!$package) {
                    throw ValidationException::withMessages([
                        'membership' => 'You need an active membership with remaining quota to book a class.',
                    ]);
                }

                $existing = ClassBooking::where('user_uuid', $member->uuid)
                    ->where('class_schedule_uuid', $schedule->uuid)
                    ->where('status', '!=', 'cancelled')
                    ->first();

                if ($existing) {
                    throw ValidationException::withMessages([
                        'booking' => 'You already booked this class schedule.',
                    ]);
                }

                $status = $this->confirmedCount($schedule, $date) < $schedule->capacity
                    ? 'confirmed'
                    : 'waiting_list';

                ClassBooking::create([
                    'user_uuid' => $member->uuid,
                    'class_schedule_uuid' => $schedule->uuid,
                    'booking_date' => $date,
                    'booking_type' => 'package',
                    'quota_used' => 0,
                    'status' => $status,
                    'booked_at' => now(),
                    'package_uuid' => $package->package_uuid,
                    'order_uuid' => $package->order_uuid,
                ]);

                return $status;
            });
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return back()->with(
            'success',
            $status === 'confirmed'
                ? 'Class booked successfully.'
                : 'Class is full. You are on the waiting list.'
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
            return back()->with('error', 'This booking is already checked in.');
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can check in.');
        }

        if ($booking->schedule?->status !== 'active') {
            return back()->with('error', 'This class schedule is not available.');
        }

        if ($booking->booking_date?->format('Y-m-d') !== now()->format('Y-m-d')) {
            return back()->with('error', 'Check-in is only available on the class day.');
        }

        try {
            $remaining = DB::transaction(function () use ($booking) {
                $fresh = ClassBooking::where('uuid', $booking->uuid)->lockForUpdate()->first();

                if ($fresh->status !== 'confirmed') {
                    throw ValidationException::withMessages([
                        'booking' => 'This booking can no longer check in.',
                    ]);
                }

                $member = User::where('uuid', $fresh->user_uuid)->firstOrFail();
                $package = MembershipService::activePackage($member, true);

                if (!$package) {
                    throw ValidationException::withMessages([
                        'membership' => 'No active membership with remaining quota. Check-in blocked.',
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
            'Checked in successfully.'
                . (is_null($remaining) ? '' : ' Remaining quota: ' . $remaining . '.')
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
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        DB::transaction(function () use ($booking) {
            $locked = ClassBooking::where('uuid', $booking->uuid)->lockForUpdate()->first();

            if (!in_array($locked->status, ['confirmed', 'waiting_list'], true)) {
                return;
            }

            $wasConfirmed = $locked->status === 'confirmed';
            $locked->update(['status' => 'cancelled']);

            if ($wasConfirmed) {
                ClassBooking::where('class_schedule_uuid', $locked->class_schedule_uuid)
                    ->whereDate('booking_date', $locked->booking_date)
                    ->where('status', 'waiting_list')
                    ->orderBy('booked_at')
                    ->lockForUpdate()
                    ->first()
                    ?->update(['status' => 'confirmed']);
            }
        });

        return back()->with('success', 'Booking cancelled.');
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
            return back()->with('error', 'This class schedule is not available.');
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
            $member->name . ' checked in successfully.'
                . (is_null($remaining) ? '' : ' Remaining quota: ' . $remaining . '.')
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
                'booking_date' => 'This class only runs on ' . ucfirst((string) $schedule->day) . 's.',
            ]);
        }
    }
}

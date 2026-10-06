<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassBooking;
use App\Models\Class\ClassSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Member-facing schedule browser (mobile phone-frame).
 *
 * Target dari tombol "View all" di Today Schedule & Upcoming Classes,
 * serta tombol Book di tabbar — yang sebelumnya tidak punya halaman.
 */
class MemberScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->hasRole('user'), 403);

        $tab = $request->query('tab', 'today');
        if (! in_array($tab, ['today', 'upcoming'], true)) {
            $tab = 'today';
        }

        $search = trim((string) $request->query('search', ''));
        $studioUuid = $request->query('studio', '');
        $level = $request->query('level', '');
        if (! in_array($level, ['foundation', 'intermediate', 'advance'], true)) {
            $level = '';
        }

        $activePackage = $user->userPackages()
            ->with('package')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
            })
            ->latest('started_at')
            ->first();

        $base = ClassSchedule::with(['class.instructor', 'studio'])
            ->withCount([
                'bookings as bookings_count' => function ($q) {
                    $q->whereIn('status', ['confirmed', 'attended']);
                },
            ])
            ->where('status', 'active')
            ->orderBy('start_time');

        if ($search !== '') {
            $like = '%' . str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search) . '%';
            $base->where(function ($q) use ($like) {
                $q->whereHas('class', function ($cq) use ($like) {
                    $cq->where('name', 'like', $like);
                })->orWhereHas('class.instructor', function ($iq) use ($like) {
                    $iq->where('name', 'like', $like);
                });
            });
        }

        if ($studioUuid !== '' && \App\Models\Studio::where('uuid', $studioUuid)->exists()) {
            $base->where('studio_uuid', $studioUuid);
        } else {
            $studioUuid = '';
        }

        if ($level !== '') {
            $base->whereHas('class', function ($q) use ($level) {
                $q->where('level', $level);
            });
        }

        $studios = \App\Models\Studio::orderBy('name')->get(['uuid', 'name']);

        $filterView = [
            'search' => $search,
            'studioUuid' => $studioUuid,
            'level' => $level,
            'studios' => $studios,
        ];

        if ($tab === 'today') {
            $date = now()->format('Y-m-d');
            $day = strtolower(now()->format('l'));

            $schedules = (clone $base)->where('day', $day)->get();

            $myBookings = ClassBooking::where('user_uuid', $user->uuid)
                ->whereDate('booking_date', $date)
                ->where('status', '!=', 'cancelled')
                ->get()
                ->keyBy(fn ($b) => $b->class_schedule_uuid . '|' . $b->booking_date?->format('Y-m-d'));

            return view('pages.mobile.schedules', array_merge($filterView, [
                'tab' => $tab,
                'date' => $date,
                'schedules' => $schedules,
                'myBookings' => $myBookings,
                'activePackage' => $activePackage,
                'unreadCount' => $user->unreadNotifications()->count(),
            ]));
        }

        // Upcoming: 7 hari ke depan (mulai besok), dikelompokkan per tanggal.
        $dates = collect(range(1, 7))->map(fn ($i) => now()->addDays($i)->format('Y-m-d'));
        $date = $dates->first();

        $byDay = (clone $base)->get()->groupBy('day');

        $groups = $dates->map(function ($date) use ($byDay) {
            $day = strtolower(Carbon::parse($date)->format('l'));

            return [
                'date' => $date,
                'day' => $day,
                'schedules' => $byDay->get($day, collect()),
            ];
        });

        $myBookings = ClassBooking::where('user_uuid', $user->uuid)
            ->whereIn('booking_date', $dates->all())
            ->where('status', '!=', 'cancelled')
            ->get()
            ->keyBy(fn ($b) => $b->class_schedule_uuid . '|' . $b->booking_date?->format('Y-m-d'));

        return view('pages.mobile.schedules', array_merge($filterView, [
            'tab' => $tab,
            'date' => $date,
            'groups' => $groups,
            'myBookings' => $myBookings,
            'activePackage' => $activePackage,
            'unreadCount' => $user->unreadNotifications()->count(),
        ]));
    }

    /**
     * My Bookings (mobile): riwayat & booking yang akan datang.
     */
    public function bookings(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->hasRole('user'), 403);

        $tab = $request->query('tab', 'upcoming');
        if (! in_array($tab, ['upcoming', 'past'], true)) {
            $tab = 'upcoming';
        }

        $activePackage = $user->userPackages()
            ->with('package')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
            })
            ->latest('started_at')
            ->first();

        $query = ClassBooking::with(['schedule.class.instructor', 'package'])
            ->where('user_uuid', $user->uuid)
            ->where('status', '!=', 'cancelled');

        if ($tab === 'upcoming') {
            $query->where('booking_date', '>=', now()->toDateString())
                ->orderBy('booking_date')
                ->orderBy('booked_at');
        } else {
            $query->where('booking_date', '<', now()->toDateString())
                ->orderByDesc('booking_date');
        }

        $bookings = $query->paginate(12)->withQueryString();

        // Global queue position for waiting-list rows on this page.
        $waitingPositions = [];
        foreach ($bookings->getCollection()->where('status', 'waiting_list') as $b) {
            $waitingPositions[$b->uuid] = ClassBooking::where('class_schedule_uuid', $b->class_schedule_uuid)
                ->whereDate('booking_date', $b->booking_date)
                ->where('status', 'waiting_list')
                ->where('booked_at', '<=', $b->booked_at)
                ->count();
        }

        return view('pages.mobile.bookings', [
            'tab' => $tab,
            'bookings' => $bookings,
            'waitingPositions' => $waitingPositions,
            'activePackage' => $activePackage,
            'unreadCount' => $user->unreadNotifications()->count(),
        ]);
    }
}

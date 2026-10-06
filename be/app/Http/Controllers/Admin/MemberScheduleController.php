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

        $activePackage = $user->userPackages()
            ->with('package')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
            })
            ->latest('started_at')
            ->first();

        $base = ClassSchedule::with(['class.instructor'])
            ->withCount([
                'bookings as bookings_count' => function ($q) {
                    $q->whereIn('status', ['confirmed', 'attended']);
                },
            ])
            ->where('status', 'active')
            ->orderBy('start_time');

        if ($tab === 'today') {
            $date = now()->format('Y-m-d');
            $day = strtolower(now()->format('l'));

            $schedules = (clone $base)->where('day', $day)->get();

            $myBookings = ClassBooking::where('user_uuid', $user->uuid)
                ->whereDate('booking_date', $date)
                ->where('status', '!=', 'cancelled')
                ->get()
                ->keyBy(fn ($b) => $b->class_schedule_uuid . '|' . $b->booking_date?->format('Y-m-d'));

            return view('pages.mobile.schedules', [
                'tab' => $tab,
                'date' => $date,
                'schedules' => $schedules,
                'myBookings' => $myBookings,
                'activePackage' => $activePackage,
                'unreadCount' => $user->unreadNotifications()->count(),
            ]);
        }

        // Upcoming: 7 hari ke depan (besok + 6 hari).
        $dates = collect(range(1, 7))
            ->map(fn ($i) => now()->addDays($i)->format('Y-m-d'));

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

        return view('pages.mobile.schedules', [
            'tab' => $tab,
            'groups' => $groups,
            'myBookings' => $myBookings,
            'activePackage' => $activePackage,
            'unreadCount' => $user->unreadNotifications()->count(),
        ]);
    }
}

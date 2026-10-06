<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Class\ClassBooking;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    /**
     * List members who purchased a membership (user packages).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);

        $query = UserPackage::with(['user', 'package', 'order']);

        if (!$isAdmin) {
            $query->where('user_uuid', $user->uuid);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search') && $isAdmin) {
            $search = $request->input('search');

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('expiring')) {
            $query->where('status', 'active')
                ->whereNotNull('expired_at')
                ->whereBetween('expired_at', [now(), now()->addDays(7)]);
        }

        $statsQuery = clone $query;

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'active' => (clone $statsQuery)->where('status', 'active')->count(),
            'expiring' => (clone $statsQuery)->where('status', 'active')
                ->whereNotNull('expired_at')
                ->whereBetween('expired_at', [now(), now()->addDays(7)])->count(),
            'expired' => (clone $statsQuery)->where('status', 'expired')->count(),
        ];

        $memberships = $query
            ->latest('started_at')
            ->paginate(10)
            ->withQueryString();

        $viewData = [
            'memberships' => $memberships,
            'stats' => $stats,
            'isAdmin' => $isAdmin,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
                'expiring' => $request->input('expiring'),
            ],
        ];

        // Member: laptop/desktop = view desktop, HP = phone-frame mobile.
        if (! $isAdmin && \App\Support\MemberView::isMobile()) {
            $viewData['unreadCount'] = $user->unreadNotifications()->count();
            return view('pages.mobile.memberships', $viewData);
        }

        return view('pages.memberships.index', $viewData);
    }

    /**
     * Member detail + booking history.
     */
    public function show(string $uuid)
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);

        $membership = UserPackage::with(['user', 'package', 'order.packageOption'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        if (!$isAdmin && $membership->user_uuid !== $user->uuid) {
            abort(403);
        }

        $bookings = ClassBooking::with(['schedule.class', 'schedule.studio'])
            ->where('user_uuid', $membership->user_uuid)
            ->latest('booked_at')
            ->limit(20)
            ->get();

        if (! $isAdmin && \App\Support\MemberView::isMobile()) {
            return view('pages.mobile.membership-show', compact('membership', 'bookings', 'isAdmin'));
        }

        return view('pages.memberships.show', compact('membership', 'bookings', 'isAdmin'));
    }
}

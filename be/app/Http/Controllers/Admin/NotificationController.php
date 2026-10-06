<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * View all own notifications.
     *
     * Role user mendapat versi mobile phone-frame; admin tetap versi desktop.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $query = $request->user()->notifications()->latest();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->paginate(15)->withQueryString();

        $data = [
            'notifications' => $notifications,
            'filter' => $filter,
            'unreadCount' => $request->user()->unreadNotifications()->count(),
        ];

        if ($request->user()->hasRole('user')) {
            return view('pages.mobile.notifications', $data);
        }

        return view('pages.notifications.index', $data);
    }

    /**
     * Mark a single notification as read (AJAX from the bell).
     */
    public function read(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all own notifications as read.
     */
    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }
}

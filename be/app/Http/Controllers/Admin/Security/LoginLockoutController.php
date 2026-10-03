<?php

namespace App\Http\Controllers\Admin\Security;

use App\Http\Controllers\Controller;
use App\Models\LoginLockout;
use Illuminate\Http\Request;

class LoginLockoutController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->trim()->value();
        $type = $request->input('type');
        $status = $request->input('status');

        $base = LoginLockout::query()
            ->when($search, fn ($query) => $query->where('value', 'like', "%{$search}%"))
            ->when($type, fn ($query) => $query->where('type', $type))
            ->when($status === 'blocked', fn ($query) => $query->active())
            ->when($status === 'tracked', fn ($query) => $query->whereNull('blocked_until'));

        $lockouts = (clone $base)
            ->orderByDesc('blocked_until')
            ->orderByDesc('last_attempt_at')
            ->paginate(15)
            ->withQueryString();

        // Stats follow the active filter so numbers stay in sync with the data.
        $stats = [
            'blocked' => (clone $base)->active()->count(),
            'tracked' => (clone $base)->count(),
            'attempts_today' => (clone $base)->whereDate('last_attempt_at', today())->count(),
        ];

        return view('pages.security.login-lockout.index', compact(
            'lockouts',
            'stats',
            'search',
            'type',
            'status',
        ));
    }

    public function destroy(LoginLockout $loginLockout)
    {
        $loginLockout->delete();

        return back()->with('success', 'Block lifted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No data selected.');
        }
        $count = LoginLockout::whereIn('id', array_map('intval', $ids))->delete();
        return back()->with('success', $count . ' blocks lifted successfully.');
    }
}
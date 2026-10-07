<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AutoLogoutInactive
{
    /**
     * Log out the user when idle longer than SESSION_INACTIVE_TIMEOUT (default 30 minutes).
     * Server-side layer: protection even when JS is disabled.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // "Stay signed in" (keep-alive) dan logout tidak boleh ikut
            // dicek timeout: tujuannya justru me-refresh last_activity,
            // termasuk saat user klik sedikit telat lewat batas 30 menit
            // pada saat popup warning masih tampil (race countdown JS).
            // 'auth.me.logout' = logout dari frontend publik (Express).
            if ($request->routeIs('keep-alive') || $request->routeIs('logout') || $request->routeIs('auth.me.logout')) {
                $request->session()->put('last_activity', time());

                return $next($request);
            }

            $timeoutMinutes = (int) config('session.inactive_timeout', 60);
            $lastActivity = $request->session()->get('last_activity');

            if ($lastActivity !== null) {
                $inactiveSeconds = time() - $lastActivity;
                if ($inactiveSeconds > $timeoutMinutes * 60) {
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    if ($request->expectsJson() || $request->is('api/*')) {
                        return response()->json([
                            'message' => 'Session expired due to ' . $timeoutMinutes . ' minutes of inactivity. Please sign in again.',
                        ], 401);
                    }

                    return redirect()
                        ->route('login')
                        ->withErrors(['session_expired' => 'Session expired due to ' . $timeoutMinutes . ' minutes of inactivity. Please sign in again.']);
                }
            }

            // update the timestamp on every authenticated request
            $request->session()->put('last_activity', time());
        }

        return $next($request);
    }
}

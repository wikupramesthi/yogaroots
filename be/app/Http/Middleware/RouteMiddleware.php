<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ManagementAccess\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

class RouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next) : Response
    // {
    //     $routes = Route::firstWhere('route', $request->route()?->getName());

    //     return blank($routes) || (bool) $routes->status && $request->user()->can($routes->permission_name)
    //         ? $next($request)
    //         : redirect(RouteServiceProvider::HOME)->withErrors('you do not have access to this route!');
    // }

    public function handle(Request $request, Closure $next): Response
    {
        // Role member hanya boleh membuka route member. Tanpa ini, member
        // yang buka dari laptop (view desktop) bisa mengakses halaman admin
        // (pengguna, articles, events, dsb.) via URL langsung karena
        // controller modul tidak punya cek role sendiri.
        $user = $request->user();
        if (
            $user && $user->hasRole('user')
            && $request->is('backend/*')
            && ! self::memberAllowed($request->route()?->getName())
        ) {
            abort(404);
        }

        $routes = Route::firstWhere(
            'route',
            $request->route()?->getName()
        );

        return blank($routes)
            || (
                (bool) $routes->status
                && $request->user()->can($routes->permission_name)
            )
            ? $next($request)
            : abort(404);
    }

    /**
     * Route yang boleh dibuka role member (sisanya khusus admin).
     * Mendukung wildcard ala Str::is().
     *
     * @return array<int, string>
     */
    private static function memberAllowed(?string $routeName): bool
    {
        if (! $routeName) {
            return false;
        }

        static $allowed = [
            'dashboard.*',
            'search', // dinonaktifkan khusus di controller (admin only)
            'profile.*',
            'keep-alive',
            'member-view',
            'locale',
            'account.*',
            'notifications.*',
            'packages.member',
            'checkout.*',
            'schedules.*',
            'bookings.*',
            'instruktur.mobile',
            'orders.*',
            'memberships.*',
            'class-bookings.*',
            'events.index',
            'events.show',
            'password.*',
            'verification.*',
            'logout',
        ];

        foreach ($allowed as $pattern) {
            if (\Illuminate\Support\Str::is($pattern, $routeName)) {
                return true;
            }
        }

        return false;
    }
}

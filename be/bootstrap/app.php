<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'route.permission' => \App\Http\Middleware\RouteMiddleware::class,
            'inactive' => \App\Http\Middleware\AutoLogoutInactive::class,
        ]);
        // Auto-logout bila 30 menit tanpa aktivitas (ala DBMSDA).
        // Server-side layer: proteksi walau JS dimatikan. JS warning
        // "Tetap Login / Logout" ada di layouts/app.blade.php (@auth).
        $middleware->appendToGroup('web', 'route.permission');
        $middleware->appendToGroup('web', \App\Http\Middleware\AutoLogoutInactive::class);
        $middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);
        $middleware->throttleApi('api');
        $middleware->prependToGroup('api', \App\Http\Middleware\ApiSecurityHeaders::class);
        $middleware->appendToGroup('api', \App\Http\Middleware\VerifyApiKey::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesi berakhir. Silakan login kembali.'], 419);
            }
            return redirect()->route('login')->withErrors(['session_expired' => 'Sesi Anda telah berakhir. Silakan login kembali.']);
        });
    })->create();

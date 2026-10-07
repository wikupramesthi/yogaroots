<?php

namespace App\Providers;

use App\Listeners\RecordFailedLogin;
use App\Listeners\RecordLoginActivity;
use App\Observers\AuditObserver;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(300)->by($request->ip());
        });

        RateLimiter::for('api-captcha', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });

        RateLimiter::for('api-contact', function (Request $request) {
            return [
                Limit::perMinute(10)->by('ip:' . $request->ip()),
                Limit::perHour(5)->by('email:' . strtolower((string) $request->input('email'))),
            ];
        });

        // Security module (DBMSDA-style): record successful/failed logins.
        Event::listen(Login::class, RecordLoginActivity::class);
        Event::listen(Failed::class, RecordFailedLogin::class);

        // Audit trail: record create/update/delete/restore for all App\Models models.
        Event::listen('eloquent.*', function (string $eventName, array $data) {
            $model = $data[0] ?? null;

            if (! $model instanceof Model) {
                return;
            }

            $action = Str::between($eventName, 'eloquent.', ':');

            if (! in_array($action, ['created', 'updated', 'deleted', 'restored'], true)) {
                return;
            }

            app(AuditObserver::class)->handle($action, $model);
        });
    }
}

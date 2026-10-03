<?php

namespace App\Listeners;

use App\Models\LoginActivity;
use App\Models\User;
use App\Notifications\LoginAnehNotification;
use App\Services\Security\AnomalyDetector;
use App\Services\Security\BruteForceProtector;
use Illuminate\Auth\Events\Login;

class RecordLoginActivity
{
    public function handle(Login $event): void
    {
        $user = $event->user;
        $ip = request()->ip();

        LoginActivity::create([
            'user_uuid' => $user?->getAuthIdentifier(),
            'name' => $user?->name,
            'email' => $user?->email,
            'ip_address' => $ip,
            'user_agent' => request()->userAgent(),
            'guard' => $event->guard,
            'logged_in_at' => now(),
        ]);

        try {
            app(BruteForceProtector::class)->clear($ip, $user?->email);
        } catch (\Throwable $e) {
            report($e);
        }

        $this->peringatkanBilaAneh($user, (string) $ip);
    }

    /**
     * Send a notification to super-admins when a login looks unusual.
     * Limited to once per user per 24 hours to avoid spam.
     */
    protected function peringatkanBilaAneh($user, string $ip): void
    {
        try {
            if (! $user || ! $user->getAuthIdentifier()) {
                return;
            }

            $detector = app(AnomalyDetector::class);
            $alasan = [];

            if ($detector->isOffHours(now())) {
                $alasan[] = 'unusual hour';
            }

            if (in_array($ip, $detector->suspiciousIps(), true)) {
                $alasan[] = 'risky IP';
            }

            if (in_array($user->getAuthIdentifier(), $detector->suspiciousUserUuids(), true)) {
                $alasan[] = 'login from multiple IPs';
            }

            if (empty($alasan)) {
                return;
            }

            $sudahDiperingatkan = $user->notifications()
                ->where('type', LoginAnehNotification::class)
                ->whereNull('read_at')
                ->where('created_at', '>=', now()->subDay())
                ->exists();

            if ($sudahDiperingatkan) {
                return;
            }

            $penerima = User::role(['super-admin', 'admin'])
                ->where('uuid', '!=', $user->getAuthIdentifier())
                ->get();

            foreach ($penerima as $orang) {
                $orang->notify(new LoginAnehNotification(
                    $user->name,
                    $user->email,
                    $ip,
                    $alasan
                ));
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}

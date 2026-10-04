<?php

namespace App\Services;

use App\Models\Package\PackageOption;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;

class MembershipService
{
    /**
     * Get the member's usable package, if any.
     *
     * Usable = status active + not expired + quota left (null = unlimited).
     */
    public static function activePackage(User $user, bool $lock = false): ?UserPackage
    {
        $query = $user->userPackages()->with('package')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('quota')->orWhere('quota', '>', 0);
            })
            ->latest('started_at');

        if ($lock) {
            $query->lockForUpdate();
        }

        return $query->first();
    }

    /**
     * Calculate membership expiry from a package option.
     */
    public static function expiryFor(PackageOption $option, ?Carbon $from = null): Carbon
    {
        $from = $from ? (clone $from) : now();

        return match ($option->duration_unit) {
            'day' => $from->addDays($option->duration),
            'week' => $from->addWeeks($option->duration),
            'year' => $from->addYears($option->duration),
            default => $from->addMonths($option->duration),
        };
    }
}

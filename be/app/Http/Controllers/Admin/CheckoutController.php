<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package\Package;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function package(Request $request, string $packageUuid)
    {
        $package = Package::with([
            'options' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('sort_order');
            },
            'features',
        ])
            ->where('uuid', $packageUuid)
            ->where('is_active', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Mobile hanya untuk role user
        |--------------------------------------------------------------------------
        */
        $isMobile = $request->header('User-Agent')
            && preg_match(
                '/Mobile|Android|iPhone|iPad/i',
                $request->header('User-Agent')
            );

        if (
            auth()->check() &&
            auth()->user()->hasRole('user') &&
            $isMobile
        ) {
            return view(
                'pages.mobile.checkout',
                compact('package')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Website / Desktop
        |--------------------------------------------------------------------------
        */
        return view(
            'pages.package.checkout',
            compact('package')
        );
    }
}

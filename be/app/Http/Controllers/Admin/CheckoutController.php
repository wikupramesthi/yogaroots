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
        | Member: laptop/desktop = view desktop, HP = phone-frame mobile.
        |--------------------------------------------------------------------------
        */
        if (auth()->check() && auth()->user()->hasRole('user') && \App\Support\MemberView::isMobile()) {
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

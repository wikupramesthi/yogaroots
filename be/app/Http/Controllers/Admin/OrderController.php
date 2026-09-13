<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package\PackageOption;
use App\Models\Payment\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Order::with([
            'user',
            'package',
            'packageOption',
            'payment',
        ]);

        /*
        |--------------------------------------------------------------------------
        | User Scope
        |--------------------------------------------------------------------------
        */

        if (!$user->hasAnyRole(['super-admin', 'admin'])) {
            $query->where('user_uuid', $user->uuid);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('search') &&
            $user->hasAnyRole(['super-admin', 'admin'])
        ) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {

                $query->where(
                    'order_number',
                    'like',
                    "%{$search}%"
                )

                    ->orWhereHas('user', function ($query) use ($search) {

                        $query->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                            ->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            );
                    })

                    ->orWhereHas('package', function ($query) use ($search) {

                        $query->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Get Orders
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'pages.orders.index',
            compact('orders')
        );
    }


    /**
     * Display the specified order.
     */
    public function show(string $uuid)
    {
        $user = Auth::user();

        $order = Order::with([
            'user',
            'package',
            'packageOption',
            'payment',
        ])
            ->where('uuid', $uuid)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | User Authorization
        |--------------------------------------------------------------------------
        */

        if (
            !$user->hasAnyRole(['super-admin', 'admin']) &&
            $order->user_uuid !== $user->uuid
        ) {
            abort(403);
        }

        return view(
            'pages.orders.show',
            compact('order')
        );
    }


    /**
     * Store a newly created order.
     *
     * This is called when the user clicks
     * "Continue to Payment".
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'type' => [
                'required',
                'in:package',
            ],

            'package_option_uuid' => [
                'required',
                'uuid',
                'exists:package_options,uuid',
            ],
        ]);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Get Package Option
        |--------------------------------------------------------------------------
        */

        $option = PackageOption::with('package')
            ->where('uuid', $validated['package_option_uuid'])
            ->where('is_active', true)
            ->first();

        if (!$option) {
            return back()
                ->withErrors([
                    'package_option_uuid' =>
                    'The selected package option is not available.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Check Package
        |--------------------------------------------------------------------------
        */

        if (
            !$option->package ||
            $option->package->is_active !== 'active'
        ) {
            return back()
                ->withErrors([
                    'package_option_uuid' =>
                    'The selected package is not available.',
                ])
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Final Price
        |--------------------------------------------------------------------------
        */

        $amount =
            $option->discount_price !== null &&
            $option->discount_price < $option->price
            ? $option->discount_price
            : $option->price;

        /*
        |--------------------------------------------------------------------------
        | Create Order
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use (
            $user,
            $option,
            $amount
        ) {

            return Order::create([

                'uuid' =>
                (string) Str::uuid(),

                'user_uuid' =>
                $user->uuid,

                'order_number' =>
                'ORD-' . strtoupper(Str::random(10)),

                'type' =>
                'package',

                'package_uuid' =>
                $option->package_uuid,

                'package_option_uuid' =>
                $option->uuid,

                'class_schedule_uuid' =>
                null,

                'amount' =>
                $amount,

                'status' =>
                'pending',

                'expired_at' =>
                now()->addHours(24),

                'paid_at' =>
                null,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        |
        | For now we redirect to order detail.
        | Later this will continue to Midtrans payment.
        |
        */

        return redirect()
            ->route(
                'orders.show',
                $order->uuid
            )
            ->with(
                'success',
                'Order created successfully.'
            );
    }
}

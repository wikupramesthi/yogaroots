<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package\PackageOption;
use App\Models\Payment\Order;
use App\Models\Payment\Payment;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\MembershipService;
use App\Notifications\MemberActiveNotification;
use App\Notifications\OrderBaruNotification;
use App\Notifications\ProofUploadedNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $this->filteredOrders($request, $user);

        /*
        |--------------------------------------------------------------------------
        | Stats (respect current scope + filters)
        |--------------------------------------------------------------------------
        */

        $stats = (clone $query)->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid,
            SUM(CASE WHEN status IN ('failed', 'expired', 'cancelled') THEN 1 ELSE 0 END) as others,
            COALESCE(SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END), 0) as revenue
        ")->first();

        /*
        |--------------------------------------------------------------------------
        | Get Orders
        |--------------------------------------------------------------------------
        */

        $orders = $query
            ->with([
                'user',
                'package',
                'packageOption',
                'payment',
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pages.orders.index', [
            'orders' => $orders,
            'stats' => $stats,
            'isAdmin' => $user->hasAnyRole(['super-admin', 'admin']),
            'filters' => [
                'search' => $request->input('search'),
                'type' => $request->input('type'),
                'status' => $request->input('status'),
                'proof' => $request->input('proof'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ],
        ]);
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

        $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);

        $userPackage = UserPackage::where('order_uuid', $order->uuid)
            ->with('package')
            ->first();

        return view(
            'pages.orders.show',
            compact('order', 'isAdmin', 'userPackage')
        );
    }


    /**
     * Mark a pending order as paid and activate the membership.
     * Admin only (manual transfer verification).
     */
    public function approve(Request $request, string $order)
    {
        abort_unless(
            Auth::user()->hasAnyRole(['super-admin', 'admin']),
            403
        );

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $orderUuid = $order;

        try {
            [$order, $userPackage] = DB::transaction(function () use ($orderUuid, $validated) {
                // Row lock + re-check inside the transaction so two
                // concurrent approvals can never activate twice.
                $order = Order::with(['packageOption', 'user'])
                    ->where('uuid', $orderUuid)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($order->status !== 'pending') {
                    throw ValidationException::withMessages([
                        'order' => 'Only pending orders can be approved.',
                    ]);
                }

                if (!$order->package_option_uuid || !$order->packageOption) {
                    throw ValidationException::withMessages([
                        'order' => 'This order has no package option to activate.',
                    ]);
                }

                $order->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'admin_note' => $validated['admin_note'] ?? null,
                ]);

                Payment::create([
                    'order_uuid' => $order->uuid,
                    'payment_gateway' => 'manual_transfer',
                    'payment_type' => 'Bank Transfer',
                    'gross_amount' => $order->amount,
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                $option = $order->packageOption;
                $started = now();

                $existing = UserPackage::where('user_uuid', $order->user_uuid)
                    ->where('package_uuid', $order->package_uuid)
                    ->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
                    })
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    // Same package bought again: extend time and add quota
                    // to the active membership instead of creating a new one.
                    $base = $existing->expired_at && $existing->expired_at->isFuture()
                        ? $existing->expired_at->copy()
                        : $started->copy();

                    $expired = match ($option->duration_unit) {
                        'day' => $base->addDays($option->duration),
                        'week' => $base->addWeeks($option->duration),
                        'year' => $base->addYears($option->duration),
                        default => $base->addMonths($option->duration),
                    };

                    $quota = $existing->quota;
                    if (!is_null($quota) && !is_null($option->quota)) {
                        $quota += $option->quota;
                    } elseif (is_null($existing->quota)) {
                        $quota = null;
                    } else {
                        $quota = $option->quota;
                    }

                    $existing->update([
                        'expired_at' => $expired,
                        'quota' => $quota,
                    ]);

                    $userPackage = $existing->fresh();
                } else {
                    $expired = match ($option->duration_unit) {
                        'day' => (clone $started)->addDays($option->duration),
                        'week' => (clone $started)->addWeeks($option->duration),
                        'year' => (clone $started)->addYears($option->duration),
                        default => (clone $started)->addMonths($option->duration),
                    };

                    $userPackage = UserPackage::create([
                        'user_uuid' => $order->user_uuid,
                        'package_uuid' => $order->package_uuid,
                        'order_uuid' => $order->uuid,
                        'quota' => $option->quota,
                        'started_at' => $started,
                        'expired_at' => $expired,
                        'status' => 'active',
                    ]);
                }

                return [$order, $userPackage];
            });
        } catch (ValidationException $e) {
            return back()->with('error', $e->getMessage());
        }

        try {
            $order->user?->notify(new MemberActiveNotification(
                $order->uuid,
                $order->order_number,
                $userPackage->expired_at,
            ));
        } catch (\Throwable $e) {
            Log::error('Membership activation notification failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('orders.show', $order->uuid)
            ->with('success', 'Order marked as paid. Membership activated.');
    }

    /**
     * Reject a pending order (manual transfer verification failed).
     * Admin only.
     */
    public function reject(Request $request, string $order)
    {
        abort_unless(
            Auth::user()->hasAnyRole(['super-admin', 'admin']),
            403
        );

        $order = Order::where('uuid', $order)->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be rejected.');
        }

        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($order, $validated) {
            $order->update([
                'status' => 'failed',
                'admin_note' => $validated['admin_note'] ?? null,
            ]);

            $order->payment?->update(['status' => 'failed']);
        });

        return back()->with('success', 'Order rejected.');
    }

    /**
     * Member uploads manual transfer proof (owner only, pending only).
     */
    public function uploadProof(Request $request, string $order)
    {
        $order = Order::where('uuid', $order)->firstOrFail();

        if ($order->user_uuid !== Auth::user()->uuid) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Proof can only be uploaded for pending orders.');
        }

        $validated = $request->validate([
            'proof' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:' . config('manual_payment.proof_max_kb', 3072),
            ],
        ]);

        $disk = config('manual_payment.proof_disk', 'public');
        $dir = config('manual_payment.proof_dir', 'proofs');

        $path = $request->file('proof')->store($dir, $disk);

        if ($order->proof_image_path) {
            Storage::disk($disk)->delete($order->proof_image_path);
        }

        $order->update([
            'proof_image_path' => $path,
            'proof_uploaded_at' => now(),
        ]);

        try {
            $order->loadMissing('user');

            $admins = User::role(['super-admin', 'admin'])
                ->where('uuid', '!=', $order->user_uuid)
                ->get();

            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ProofUploadedNotification(
                    $order->uuid,
                    $order->order_number,
                    $order->user?->name ?? '-',
                    (float) $order->amount,
                ));
            }
        } catch (\Throwable $e) {
            Log::error('Proof upload notification failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Transfer proof uploaded. Please wait for admin verification.');
    }

    /**
     * Serve the transfer proof file (owner or admin only).
     * Never exposed as a guessable public URL.
     */
    public function showProof(Request $request, string $order)
    {
        $order = Order::where('uuid', $order)->firstOrFail();

        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);

        if (!$isAdmin && $order->user_uuid !== $user->uuid) {
            abort(403);
        }

        if (!$order->proof_image_path) {
            abort(404);
        }

        $diskName = config('manual_payment.proof_disk', 'local');
        $disk = Storage::disk($diskName);

        // Backward compatibility with proofs stored on the public disk.
        if (!$disk->exists($order->proof_image_path) && $diskName !== 'public') {
            $disk = Storage::disk('public');
        }

        if (!$disk->exists($order->proof_image_path)) {
            abort(404);
        }

        return response()->file($disk->path($order->proof_image_path));
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

        // Reject buying a different package while one is still active.
        $activePackage = MembershipService::activePackage($user);

        if ($activePackage && $activePackage->package_uuid !== $option->package_uuid) {
            return back()
                ->withErrors([
                    'package_option_uuid' =>
                    'You still have an active package. You can only buy the same package again until it expires.',
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
        | Reuse Recent Pending Order (anti spam + anti notif flood)
        |--------------------------------------------------------------------------
        */

        $existingPending = Order::where('user_uuid', $user->uuid)
            ->where('type', 'package')
            ->where('package_option_uuid', $option->uuid)
            ->where('status', 'pending')
            ->where('created_at', '>', now()->subHour())
            ->latest()
            ->first();

        if ($existingPending) {
            return redirect()
                ->route(
                    'orders.show',
                    $existingPending->uuid
                )
                ->with(
                    'success',
                    'You already have a pending order for this option. Please complete the payment.'
                );
        }

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
        | Notify Admins
        |--------------------------------------------------------------------------
        |
        | Manual transfer: admins verify the order and
        | activate the membership from the order detail.
        |
        */

        $this->notifyAdmins($order);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
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

    /**
     * Professional order report (screen preview + print).
     */
    public function report(Request $request)
    {
        $user = Auth::user();

        $orders = $this->filteredOrders($request, $user)
            ->with([
                'user',
                'package',
                'packageOption',
                'payment',
            ])
            ->latest()
            ->limit(1000)
            ->get();

        return view('pages.orders.report', array_merge(
            $this->reportData($orders, $request, $user),
            ['isScreen' => true]
        ));
    }

    /**
     * Download order report as PDF.
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $orders = $this->filteredOrders($request, $user)
            ->with([
                'user',
                'package',
                'packageOption',
                'payment',
            ])
            ->latest()
            ->limit(1000)
            ->get();

        $pdf = Pdf::loadView(
            'pages.orders.laporan',
            $this->reportData($orders, $request, $user)
        )->setPaper('a4', 'landscape');

        return $pdf->download('order-report-' . now()->format('Ymd-His') . '.pdf');
    }

    /**
     * Shared scoped + filtered orders query (no eager loads, no ordering).
     */
    private function filteredOrders(Request $request, $user)
    {
        $query = Order::query();

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
            $query->where('status', $request->input('status'));
        }

        if ($request->input('proof') === 'uploaded') {
            $query->whereNotNull('proof_image_path');
        } elseif ($request->input('proof') === 'missing') {
            $query->whereNull('proof_image_path');
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
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
            $search = $request->input('search');

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

        return $query;
    }

    /**
     * Shared report summary + meta.
     */
    private function reportData($orders, Request $request, $user): array
    {
        $paid = $orders->where('status', 'paid');

        return [
            'orders' => $orders,
            'total' => $orders->count(),
            'pendingCount' => $orders->where('status', 'pending')->count(),
            'paidCount' => $paid->count(),
            'failedCount' => $orders->whereIn('status', ['failed', 'expired', 'cancelled'])->count(),
            'revenue' => $paid->sum('amount'),
            'periode' => $this->reportPeriod($request),
            'filterStatus' => $request->input('status', 'All'),
            'filterType' => $request->input('type', 'All'),
            'search' => $request->input('search'),
            'isAdmin' => $user->hasAnyRole(['super-admin', 'admin']),
            'dicetakOleh' => $user->name ?? 'System',
            'waktuCetak' => now()->translatedFormat('d F Y H:i'),
        ];
    }

    /**
     * Human readable report period label.
     */
    private function reportPeriod(Request $request): string
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            return $request->input('start_date') . ' to ' . $request->input('end_date');
        }

        if ($request->filled('start_date')) {
            return 'Since ' . $request->input('start_date');
        }

        if ($request->filled('end_date')) {
            return 'Until ' . $request->input('end_date');
        }

        return 'All Periods';
    }

    /**
     * Notify all admins about a new order (never breaks checkout).
     */
    private function notifyAdmins(Order $order): void
    {
        try {
            $order->loadMissing(['user', 'package', 'packageOption']);

            $admins = User::role(['super-admin', 'admin'])
                ->where('uuid', '!=', $order->user_uuid)
                ->get();

            if ($admins->isEmpty()) {
                return;
            }

            $packageName = $order->package?->name ?? '-';
            if ($order->packageOption?->name) {
                $packageName .= ' — ' . $order->packageOption->name;
            }

            Notification::send($admins, new OrderBaruNotification(
                $order->uuid,
                $order->order_number,
                $order->user?->name ?? '-',
                $packageName,
                (float) $order->amount,
            ));
        } catch (\Throwable $e) {
            Log::error('Order admin notification failed: ' . $e->getMessage());
        }
    }
}

@extends('layouts.mobile')
@section('title', __('mobile.my_orders_title'))
@section('content')

<section class="screen active" id="orders">
    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="mb-1">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center mb-3" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>
            <p class="eyebrow mb-1">{{ __('mobile.membership') }}</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ __('mobile.my_orders_title') }}</h1>
            <p class="small text-muted2 mb-0 mt-1">
                {{ trans_choice('mobile.orders_count', $orders->total(), ['count' => $orders->total()]) }}
            </p>
        </div>

        {{-- STATUS FILTERS --}}
        <div class="d-flex gap-2 mt-4" style="overflow-x:auto;">
            <a href="{{ route('orders.index', request()->except('status')) }}"
                class="filter d-inline-block text-decoration-none text-nowrap {{ empty($filters['status']) ? 'active' : '' }}">{{ __('mobile.all') }}</a>
            @foreach (['paid' => __('mobile.order_status.paid'), 'pending' => __('mobile.order_status.pending'), 'failed' => __('mobile.order_status.failed'), 'expired' => __('mobile.order_status.expired'), 'cancelled' => __('mobile.order_status.cancelled')] as $st => $label)
                <a href="{{ route('orders.index', array_merge(request()->except('status'), ['status' => $st])) }}"
                    class="filter d-inline-block text-decoration-none text-nowrap {{ ($filters['status'] ?? '') === $st ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- LIST --}}
        <div class="d-grid gap-3 mt-3" style="max-height: calc(100vh - 350px); overflow-y: auto; padding-right: 2px;">
            @forelse ($orders as $order)
                @php
                    $badge = match ($order->status) {
                        'paid' => 'bg-success-subtle text-success',
                        'pending' => 'bg-warning-subtle text-warning',
                        'failed' => 'bg-danger-subtle text-danger',
                        default => 'bg-secondary-subtle text-secondary',
                    };
                @endphp
                <a href="{{ route('orders.show', $order->uuid) }}"
                    class="app-card p-3 text-decoration-none text-dark d-block">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center bg-sage-soft text-sage flex-shrink-0"
                            style="width:42px;height:42px;">
                            <i class="bi {{ $order->type === 'package' ? 'bi-flower1' : 'bi-calendar-event' }}"></i>
                        </div>
                        <div class="flex-fill">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <p class="small fw-semibold mb-1">
                                        {{ $order->package?->name ?? 'Single Class' }}
                                        @if ($order->packageOption?->name)
                                            <small class="d-block text-muted2 fw-normal">{{ $order->packageOption->name }}</small>
                                        @endif
                                    </p>
                                    <p class="text-muted2 mb-0 m-meta">#{{ $order->order_number }}</p>
                                </div>
                                <span class="badge rounded-pill {{ $badge }}">{{ __('mobile.order_status.' . $order->status) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center gap-2 mt-2">
                                <p class="small text-muted2 mb-0">{{ $order->created_at?->format('d M Y') }}</p>
                                <p class="small fw-semibold mb-0">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                            </div>
                            <p class="mb-0 text-sage fw-semibold mt-2 m-micro">
                                {{ __('mobile.tap_to_view') }}{{ $order->status === 'pending' ? ' ' . __('mobile.tap_upload_suffix') : '' }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="app-card text-center p-4">
                    <i class="bi bi-bag-x text-muted2 fs-3"></i>
                    <p class="small fw-semibold mt-2 mb-0">{{ __('mobile.no_orders') }}</p>
                    <p class="text-muted2 mb-0 text-small">
                        {{ __('mobile.no_orders_desc') }}
                    </p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if ($orders->hasPages())
            <div class="d-flex align-items-center justify-content-between mt-4">
                @if ($orders->onFirstPage())
                    <span></span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="filter d-inline-block text-decoration-none">{{ __('mobile.newer') }}</a>
                @endif
                <span class="text-muted2 text-small">
                    {{ __('mobile.page_of', ['current' => $orders->currentPage(), 'last' => $orders->lastPage()]) }}
                </span>
                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="filter d-inline-block text-decoration-none">{{ __('mobile.older') }}</a>
                @else
                    <span></span>
                @endif
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@endsection

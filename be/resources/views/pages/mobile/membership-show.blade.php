@extends('layouts.mobile')
@section('title', __('mobile.membership_detail'))
@section('content')

<section class="screen active" id="membership-detail">
    <div class="px-4 pt-4">

        <a href="{{ route('memberships.index') }}"
            class="text-dark text-decoration-none d-inline-flex align-items-center mb-3" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>

        <p class="eyebrow mb-1">{{ __('mobile.membership') }}</p>
        <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ $membership->package?->name ?? __('mobile.membership') }}</h1>
        <p class="small text-muted2 mb-0 mt-1">
            <span class="badge rounded-pill {{ $membership->status === 'active' ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis' }}">
                {{ __('mobile.membership_status.' . $membership->status) }}
            </span>
        </p>

        {{-- QUOTA CARD --}}
        <div class="app-card d-flex align-items-center gap-3 p-3 mt-3">
            <div class="grad-sage d-flex align-items-center justify-content-center flex-shrink-0"
                style="height: 48px; width: 48px; border-radius: 18px">
                <i class="bi bi-flower1 text-white"></i>
            </div>
            <div class="flex-fill">
                <p class="mb-0 small fw-semibold">
                    @if (is_null($membership->quota))
                        {{ __('mobile.unlimited_classes') }}
                    @else
                        {{ $membership->quota == 1 ? __('mobile.class_left', ['count' => $membership->quota]) : __('mobile.classes_left', ['count' => $membership->quota]) }}
                    @endif
                </p>
                <p class="mb-0 text-muted2 m-meta">
                    {{ $membership->started_at?->format('d M Y') ?? '-' }}
                    →
                    {{ $membership->expired_at?->format('d M Y') ?? '-' }}
                </p>
            </div>
        </div>

        @if ($membership->started_at && $membership->expired_at)
            @php
                $total = max(1, $membership->started_at->diffInSeconds($membership->expired_at));
                $remaining = max(0, now()->diffInSeconds($membership->expired_at, false));
                $pct = min(100, max(0, $remaining / $total * 100));
            @endphp
            <div class="progress mt-2" style="height: 6px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%; background: var(--sage);"></div>
            </div>
        @endif

        {{-- DETAIL --}}
        <div class="app-card p-3 mt-3">
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted2 text-small">{{ __('mobile.package') }}</span>
                <span class="small fw-semibold">{{ $membership->package?->name ?? '-' }}</span>
            </div>
            @if ($membership->order)
                <a href="{{ route('orders.show', $membership->order->uuid) }}" class="d-flex justify-content-between py-2 border-bottom text-decoration-none text-dark">
                    <span class="text-muted2 text-small">{{ __('mobile.order') }}</span>
                    <span class="small fw-semibold text-terra">#{{ $membership->order->order_number }} →</span>
                </a>
            @endif
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted2 text-small">{{ __('mobile.started') }}</span>
                <span class="small fw-semibold">{{ $membership->started_at?->format('d M Y H:i') ?? '-' }}</span>
            </div>
            <div class="d-flex justify-content-between py-2">
                <span class="text-muted2 text-small">{{ __('mobile.expires') }}</span>
                <span class="small fw-semibold">{{ $membership->expired_at?->format('d M Y H:i') ?? '-' }}</span>
            </div>
        </div>

        {{-- BOOKING HISTORY --}}
        <div class="d-flex justify-content-between align-items-end mt-4">
            <h3 class="h5 fw-semibold mb-0">{{ __('mobile.recent_classes') }}</h3>
            <a href="{{ route('bookings.my') }}" class="btn btn-link p-0 text-terra fw-semibold text-small text-decoration-none">{{ __('mobile.view_all') }}</a>
        </div>
        <div class="d-grid gap-3 mt-3">
            @forelse ($bookings as $b)
                <div class="app-card p-3">
                    <p class="mb-1 small fw-semibold">{{ $b->schedule?->class?->name ?? 'Class' }}</p>
                    <p class="mb-0 text-muted2 m-meta">
                        {{ $b->booking_date?->format('d M Y') ?? '-' }}
                        · {{ substr((string) $b->schedule?->start_time, 0, 5) }}–{{ substr((string) $b->schedule?->end_time, 0, 5) }}
                        · {{ ucfirst($b->status) }}
                    </p>
                </div>
            @empty
                <div class="app-card text-center p-4">
                    <p class="mb-0 text-muted2 text-small">{{ __('mobile.no_classes_membership') }}</p>
                </div>
            @endforelse
        </div>

        <a href="{{ route('schedules.index') }}" class="btn btn-sage w-100 py-2 mt-4">
            <i class="bi bi-calendar-plus me-1"></i> Book a Class
        </a>

        <div style="height: 24px"></div>
    </div>
</section>

@endsection

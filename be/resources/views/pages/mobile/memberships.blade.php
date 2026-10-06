@extends('layouts.mobile')
@section('title', __('mobile.my_membership'))
@section('content')

<section class="screen active" id="membership">
    <div class="px-4 pt-4">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center"
                onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>
            <a href="{{ route('notifications.index') }}"
                class="app-card border-0 rounded-circle position-relative d-flex align-items-center justify-content-center text-dark text-decoration-none flex-shrink-0"
                style="height: 44px; width: 44px; border-radius: 50% !important" aria-label="{{ __('mobile.notifications') }}">
                <i class="bi bi-bell"></i>
                @if (!empty($unreadCount))
                    <span class="position-absolute rounded-circle"
                        style="height: 8px; width: 8px; background: var(--terra); top: 10px; right: 10px;"></span>
                @endif
            </a>
        </div>

        <div class="mb-1">
            <p class="eyebrow mb-1">{{ __('mobile.membership') }}</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ __('mobile.my_membership') }}</h1>
            <p class="small text-muted2 mb-0 mt-1">
                {{ $stats['active'] }} {{ strtolower(__('mobile.active')) }}
                @if ($stats['expiring'] > 0)
                    · <span class="text-warning fw-semibold">{{ __('mobile.expiring_count', ['count' => $stats['expiring']]) }}</span>
                @endif
            </p>
        </div>

        {{-- FILTER --}}
        <div class="d-flex gap-2 mt-4" style="overflow-x:auto;scrollbar-width:none;">
            @php $st = $filters['status'] ?? ''; @endphp
            <a href="{{ route('memberships.index') }}"
                class="filter d-inline-block text-decoration-none {{ $st === '' ? 'active' : '' }}">{{ __('mobile.all') }}</a>
            <a href="{{ route('memberships.index', ['status' => 'active']) }}"
                class="filter d-inline-block text-decoration-none {{ $st === 'active' ? 'active' : '' }}">{{ __('mobile.membership_status.active') }}</a>
            <a href="{{ route('memberships.index', ['status' => 'expired']) }}"
                class="filter d-inline-block text-decoration-none {{ $st === 'expired' ? 'active' : '' }}">{{ __('mobile.membership_status.expired') }}</a>
        </div>

        {{-- LIST --}}
        <div class="d-grid gap-3 mt-3">
            @forelse ($memberships as $m)
                @php
                    $isActive = $m->status === 'active';
                    $badge = $isActive ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis';
                    $expiringSoon = $isActive && $m->expired_at && $m->expired_at->isFuture() && $m->expired_at->diffInDays(now()) <= 7;
                @endphp
                <a href="{{ route('memberships.show', $m->uuid) }}" class="app-card p-3 text-decoration-none text-dark d-block">
                    <div class="d-flex align-items-center gap-3">
                        <div class="grad-sage d-flex align-items-center justify-content-center flex-shrink-0"
                            style="height: 48px; width: 48px; border-radius: 18px">
                            <i class="bi bi-flower1 text-white"></i>
                        </div>
                        <div class="flex-fill" style="min-width:0">
                            <p class="mb-0 small fw-semibold text-truncate">{{ $m->package?->name ?? 'Membership' }}</p>
                            <p class="mb-0 text-muted2 m-meta">
                                @if (is_null($m->quota))
                                    {{ __('mobile.unlimited_classes') }}
                                @else
                                    {{ $m->quota == 1 ? __('mobile.class_left', ['count' => $m->quota]) : __('mobile.classes_left', ['count' => $m->quota]) }}
                                @endif
                                @if ($m->expired_at)
                                    · {{ __('mobile.until', ['date' => $m->expired_at->format('d M Y')]) }}
                                @endif
                            </p>
                        </div>
                        <span class="badge rounded-pill {{ $badge }}">{{ __('mobile.membership_status.' . $m->status) }}</span>
                    </div>
                    @if ($expiringSoon)
                        <div class="mt-2 p-2 rounded-3 bg-warning-subtle text-warning-emphasis m-meta fw-semibold">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ __('mobile.expiring_soon', ['date' => $m->expired_at->format('d M Y')]) }}
                        </div>
                    @endif
                    @if ($m->started_at && $m->expired_at)
                        @php
                            $total = max(1, $m->started_at->diffInSeconds($m->expired_at));
                            $remaining = max(0, now()->diffInSeconds($m->expired_at, false));
                            $pct = min(100, max(0, $remaining / $total * 100));
                        @endphp
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%; background: var(--sage);"></div>
                        </div>
                    @endif
                </a>
            @empty
                <div class="app-card text-center p-4">
                    <i class="bi bi-flower1 text-muted2 fs-3"></i>
                    <p class="mb-1 small fw-semibold">{{ __('mobile.no_membership') }}</p>
                    <p class="mb-3 text-muted2 text-small">{{ __('mobile.no_membership_desc') }}</p>
                    <a href="{{ route('packages.member') }}" class="btn btn-warm px-4 py-2">{{ __('mobile.browse_packages') }}</a>
                </div>
            @endforelse
        </div>

        @if ($memberships instanceof \Illuminate\Pagination\LengthAwarePaginator && $memberships->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $memberships->links() }}
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@endsection

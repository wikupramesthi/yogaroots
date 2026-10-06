@extends('layouts.mobile')
@section('title', __('mobile.events'))
@section('content')

<section class="screen active" id="events">
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
            <p class="eyebrow mb-1">{{ __('mobile.events') }}</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ __('mobile.events_workshops') }}</h1>
            <p class="small text-muted2 mb-0 mt-1">{{ trans_choice('mobile.events_count', $events->total(), ['count' => $events->total()]) }}</p>
        </div>

        <form method="GET" action="{{ route('events.index') }}" class="mt-3">
            <div class="app-card d-flex align-items-center gap-2 px-3 py-2">
                <i class="bi bi-search text-muted2"></i>
                <input type="search" name="search" value="{{ $search }}"
                    class="border-0 bg-transparent w-100 small" style="outline:none"
                    placeholder="{{ __('mobile.search_events') }}" autocomplete="off">
                @if (!empty($search))
                    <a href="{{ route('events.index') }}" class="text-muted2" aria-label="Clear search">
                        <i class="bi bi-x-circle"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="d-grid gap-3 mt-3">
            @forelse ($events as $event)
                @php
                    $img = $event->gambar
                        ? (Str::startsWith($event->gambar, 'http') ? $event->gambar : asset('storage/' . $event->gambar))
                        : asset('dist/assets/images/event-placeholder.jpg');
                @endphp
                <a href="{{ route('events.show', $event->uuid) }}" class="app-card overflow-hidden text-decoration-none text-dark d-block">
                    <img src="{{ $img }}" alt="{{ $event->judul }}" loading="lazy" decoding="async"
                        style="height:150px;width:100%;object-fit:cover">
                    <div class="p-3">
                        <span class="chip bg-terra-soft text-terra text-uppercase m-micro">{{ __('mobile.event') }}</span>
                        <p class="mb-1 mt-2 small fw-semibold lh-sm">{{ $event->judul }}</p>
                        <p class="mb-0 text-muted2 m-meta">
                            <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                            @if ($event->waktu_mulai)
                                · {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                            @endif
                            @if ($event->lokasi)
                                · {{ $event->lokasi }}
                            @endif
                        </p>
                    </div>
                </a>
            @empty
                <div class="app-card text-center p-4">
                    <i class="bi bi-calendar2-week text-muted2 fs-3"></i>
                    <p class="mb-1 small fw-semibold">{{ __('mobile.no_events') }}</p>
                    <p class="mb-0 text-muted2 text-small">{{ __('mobile.no_events_desc') }}</p>
                </div>
            @endforelse
        </div>

        @if ($events->hasPages())
            <div class="d-flex align-items-center justify-content-between mt-4">
                @if ($events->onFirstPage())
                    <span></span>
                @else
                    <a href="{{ $events->previousPageUrl() }}" class="filter d-inline-block text-decoration-none">{{ __('mobile.newer') }}</a>
                @endif
                <span class="text-muted2" style="font-size:12px">
                    {{ __('mobile.page_of', ['current' => $events->currentPage(), 'last' => $events->lastPage()]) }}
                </span>
                @if ($events->hasMorePages())
                    <a href="{{ $events->nextPageUrl() }}" class="filter d-inline-block text-decoration-none">{{ __('mobile.older') }}</a>
                @else
                    <span></span>
                @endif
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

@endsection

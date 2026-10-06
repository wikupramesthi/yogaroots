@extends('layouts.mobile')
@section('title', $event->judul)
@section('content')

<section class="screen active" id="event-detail">
    <div class="px-4 pt-4">

        <a href="{{ route('events.index') }}"
            class="text-dark text-decoration-none d-inline-flex align-items-center mb-3" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>

        @php
            $img = $event->gambar
                ? (Str::startsWith($event->gambar, 'http') ? $event->gambar : asset('storage/' . $event->gambar))
                : null;
        @endphp

        @if ($img)
            <div class="hero">
                <img src="{{ $img }}" alt="{{ $event->judul }}" fetchpriority="high" decoding="async">
                <div class="veil"></div>
                <div class="position-absolute bottom-0 start-0 end-0 p-4">
                    <span class="chip bg-light text-dark">
                        <i class="bi bi-calendar-event text-terra"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                    </span>
                </div>
            </div>
        @endif

        <p class="eyebrow mb-1 mt-4">{{ __('mobile.event') }}</p>
        <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ $event->judul }}</h1>

        @if ($event->excerpt)
            <p class="small fw-semibold mt-2 mb-0">{{ $event->excerpt }}</p>
        @endif

        <div class="app-card p-3 mt-3">
            <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                <i class="bi bi-calendar3 text-sage"></i>
                <span class="small">{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}</span>
            </div>
            @if ($event->waktu_mulai)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <i class="bi bi-clock text-sage"></i>
                    <span class="small">
                        {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                        @if ($event->waktu_selesai)
                            - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                        @endif
                    </span>
                </div>
            @endif
            @if ($event->lokasi)
                <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                    <i class="bi bi-geo-alt text-sage"></i>
                    <span class="small">{{ $event->lokasi }}</span>
                </div>
            @endif
            @if ($event->kapasitas)
                <div class="d-flex align-items-center gap-3 py-2">
                    <i class="bi bi-people text-sage"></i>
                    <span class="small">{{ __('mobile.capacity', ['count' => $event->kapasitas]) }}</span>
                </div>
            @endif
        </div>

        @if ($event->deskripsi)
            <div class="app-card p-4 mt-3">
                <div class="small text-muted2 lh-lg event-description">
                    {!! $event->deskripsi !!}
                </div>
            </div>
        @endif

        <a href="{{ route('schedules.index') }}" class="btn btn-sage w-100 py-2 mt-4">
            <i class="bi bi-calendar-plus me-1"></i> Browse Class Schedules
        </a>

        <div style="height: 24px"></div>
    </div>
</section>

@endsection

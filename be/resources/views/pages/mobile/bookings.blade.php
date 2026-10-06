@extends('layouts.mobile')
@section('title', 'My Bookings')
@section('content')

<section class="screen active" id="bookings">
    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="mb-1">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center mb-3">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <p class="eyebrow mb-1">Classes</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">
                My Bookings
            </h1>
            <p class="small text-muted2 mb-0 mt-1">
                {{ $bookings->total() }} booking{{ $bookings->total() === 1 ? '' : 's' }}
            </p>
        </div>

        {{-- FILTER --}}
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('bookings.my', ['tab' => 'upcoming']) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'upcoming' ? 'active' : '' }}">
                Upcoming
            </a>
            <a href="{{ route('bookings.my', ['tab' => 'past']) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'past' ? 'active' : '' }}">
                Past
            </a>
        </div>

        {{-- LIST --}}
        <div class="d-grid gap-3 mt-3" style="max-height: calc(100vh - 310px); overflow-y: auto; padding-right: 2px;">
            @forelse ($bookings as $booking)
                @php
                    $schedule = $booking->schedule;
                    $class = $schedule?->class;
                    $instructor = $class?->instructor;
                    $start = $schedule ? \Carbon\Carbon::parse($schedule->start_time) : null;
                    $end = $schedule ? \Carbon\Carbon::parse($schedule->end_time) : null;
                    $isToday = $booking->booking_date?->format('Y-m-d') === now()->format('Y-m-d');
                    $isPast = $booking->booking_date?->format('Y-m-d') < now()->format('Y-m-d');

                    $statusBadge = match ($booking->status) {
                        'attended' => 'bg-success-subtle text-success-emphasis',
                        'waiting_list' => 'bg-warning-subtle text-warning-emphasis',
                        'confirmed' => 'bg-primary-subtle text-primary-emphasis',
                        default => 'bg-secondary-subtle text-secondary-emphasis',
                    };

                    $statusLabel = match ($booking->status) {
                        'attended' => 'Done',
                        'waiting_list' => 'Waiting',
                        'confirmed' => 'Booked',
                        default => ucfirst($booking->status),
                    };
                @endphp

                <div class="app-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex flex-column align-items-center justify-content-center bg-sage-soft flex-shrink-0"
                            style="width:52px;height:52px;border-radius:15px;">
                            @if ($booking->booking_date)
                                <span class="fw-bold text-sage" style="font-size:17px;line-height:1;">
                                    {{ $booking->booking_date->format('d') }}
                                </span>
                                <span class="text-muted2 text-uppercase mt-1 m-tiny">
                                    {{ $booking->booking_date->format('M') }}
                                </span>
                            @else
                                <i class="bi bi-calendar-event text-sage"></i>
                            @endif
                        </div>

                        <div class="flex-fill" style="min-width:0">
                            <p class="mb-1 small fw-semibold text-truncate">
                                {{ $class?->name ?? 'Class unavailable' }}
                            </p>
                            <p class="mb-1 text-muted2 text-truncate text-small">
                                <i class="bi bi-person me-1"></i>{{ $instructor?->name ?? 'No instructor' }}
                            </p>
                            <p class="mb-0 text-muted2 text-truncate text-small">
                                <i class="bi bi-clock me-1"></i>{{ $start ? $start->format('H:i') : '-' }} - {{ $end ? $end->format('H:i') : '-' }}
                            </p>
                        </div>

                        <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                            <span class="badge rounded-pill {{ $statusBadge }}">{{ $statusLabel }}</span>

                            @if ($booking->status === 'confirmed' && $isToday)
                                <form action="{{ route('class-bookings.checkin', $booking->uuid) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-warm btn-sm text-nowrap">Check In</button>
                                </form>
                            @endif

                            @if (in_array($booking->status, ['confirmed', 'waiting_list']) && !$isPast)
                                <form action="{{ route('class-bookings.cancel', $booking->uuid) }}" method="POST" class="m-0"
                                    onsubmit="return confirm('Cancel this booking?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary text-nowrap">Cancel</button>
                                </form>
                                <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap"
                                    data-bs-toggle="modal" data-bs-target="#bookingQrModal"
                                    data-qr="{{ $booking->uuid }}"
                                    data-title="{{ $class?->name }} · {{ $booking->booking_date?->format('d M Y') }}">
                                    <i class="bi bi-qr-code"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="app-card text-center p-4">
                    <i class="bi bi-calendar2-week text-muted2 fs-3"></i>
                    <p class="mb-1 mt-2 small fw-semibold">
                        No {{ $tab === 'upcoming' ? 'upcoming' : 'past' }} bookings
                    </p>
                    <p class="mb-0 text-muted2 text-small">
                        Your class bookings will appear here.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if ($bookings->hasPages())
            <div class="d-flex align-items-center justify-content-between mt-4">
                @if ($bookings->onFirstPage())
                    <span></span>
                @else
                    <a href="{{ $bookings->previousPageUrl() }}" class="filter d-inline-block text-decoration-none">← Newer</a>
                @endif
                <span class="text-muted2" style="font-size:12px">
                    Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
                </span>
                @if ($bookings->hasMorePages())
                    <a href="{{ $bookings->nextPageUrl() }}" class="filter d-inline-block text-decoration-none">Older →</a>
                @else
                    <span></span>
                @endif
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

{{-- QR Modal --}}
<div class="modal fade" id="bookingQrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body p-4 text-center">
                <span class="chip bg-sage-soft text-sage text-uppercase m-micro">Check In</span>
                <h5 class="fw-bold mt-2 mb-1" data-qr-title>Booking</h5>
                <p class="text-muted2 m-micro mb-3">Tunjukkan QR ini ke admin untuk check-in</p>
                <canvas id="bookingQrCanvas" width="200" height="200" class="mx-auto d-block"></canvas>
            </div>
        </div>
    </div>
</div>

@push('after-script')
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('bookingQrModal');
        if (modal && window.QRious) {
            modal.addEventListener('show.bs.modal', function (e) {
                var btn = e.relatedTarget || modal.querySelector('[data-qr]');
                var uuid = btn.getAttribute('data-qr') || '';
                var title = btn.getAttribute('data-title') || '';
                var canvas = document.getElementById('bookingQrCanvas');
                if (title) { modal.querySelector('[data-qr-title]').textContent = title; }
                new QRious({ element: canvas, value: 'BOOKING:' + uuid, size: 200 });
            });
        }
    });
</script>
@endpush

@endsection

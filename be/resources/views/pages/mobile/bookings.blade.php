@extends('layouts.mobile')
@section('title', __('mobile.my_bookings'))
@section('content')

<section class="screen active" id="bookings">
    <div class="px-4 pt-4">

        {{-- HEADER --}}
        <div class="mb-1">
            <a href="{{ route('dashboard.index') }}"
                class="text-dark text-decoration-none d-inline-flex align-items-center mb-3" onclick="if (window.history.length > 1) { window.history.back(); return false; }">
                <i class="bi bi-arrow-left fs-5"></i>
                <span class="ms-2 small fw-semibold">{{ __('mobile.back') }}</span>
            </a>
            <p class="eyebrow mb-1">{{ __('mobile.classes') }}</p>
            <h1 class="fw-semibold mb-0" style="font-size: 28px;">{{ __('mobile.my_bookings') }}</h1>
            <p class="small text-muted2 mb-0 mt-1">
                {{ trans_choice('mobile.booked_count', $bookings->total(), ['count' => $bookings->total()]) }}
            </p>
        </div>

        {{-- FILTER --}}
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('bookings.my', ['tab' => 'upcoming']) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'upcoming' ? 'active' : '' }}">{{ __('mobile.upcoming') }}</a>
            <a href="{{ route('bookings.my', ['tab' => 'past']) }}"
                class="filter d-inline-block text-decoration-none {{ $tab === 'past' ? 'active' : '' }}">{{ __('mobile.past') }}</a>
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
                    $classAt = ($booking->booking_date && $start)
                        ? $booking->booking_date->copy()->setTime($start->hour, $start->minute)
                        : null;
                    $canCancel = $booking->status === 'waiting_list'
                        ? ! $isPast
                        : ($classAt && $classAt->greaterThan(now()->addHours(2)));

                    $statusBadge = match ($booking->status) {
                        'attended' => 'bg-success-subtle text-success-emphasis',
                        'waiting_list' => 'bg-warning-subtle text-warning-emphasis',
                        'confirmed' => 'bg-primary-subtle text-primary-emphasis',
                        default => 'bg-secondary-subtle text-secondary-emphasis',
                    };

                    $statusLabel = match ($booking->status) {
                        'attended' => __('mobile.done'),
                        'waiting_list' => 'Waiting' . (isset($waitingPositions[$booking->uuid]) ? ' · #' . $waitingPositions[$booking->uuid] : ''),
                        'confirmed' => __('mobile.booked'),
                        default => __('mobile.booking_status.' . $booking->status),
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
                            @if ($booking->status === 'waiting_list' && isset($waitingPositions[$booking->uuid]))
                                <p class="mb-1 m-micro fw-semibold text-warning-emphasis">
                                    {{ __('mobile.waiting_position', ['n' => $waitingPositions[$booking->uuid]]) }}
                                </p>
                            @endif
                            <p class="mb-1 text-muted2 text-truncate text-small">
                                <i class="bi bi-person me-1"></i>{{ $instructor?->name ?? 'No instructor' }}
                            </p>
                            <p class="mb-0 text-muted2 text-truncate text-small">
                                <i class="bi bi-clock me-1"></i>{{ $start ? $start->format('H:i') : '-' }} - {{ $end ? $end->format('H:i') : '-' }}
                            </p>
                        </div>

                        <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                            <span class="badge rounded-pill {{ $statusBadge }}">{{ $statusLabel }}</span>

                            @if ($booking->status === 'attended' && $tab === 'past')
                                @if (is_null($booking->rating))
                                    <button type="button" class="btn btn-sm btn-warm text-nowrap"
                                        data-bs-toggle="modal" data-bs-target="#rateModal"
                                        data-action="{{ route('class-bookings.rate', $booking->uuid) }}"
                                        data-title="{{ $class?->name ?? 'Class' }}">
                                        <i class="bi bi-star me-1"></i>Rate
                                    </button>
                                @else
                                    <span class="text-warning text-nowrap" aria-label="{{ __('mobile.rated_of', ['n' => $booking->rating]) }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $booking->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </span>
                                @endif
                            @endif

                            @if ($booking->status === 'confirmed' && $isToday)
                                <form action="{{ route('class-bookings.checkin', $booking->uuid) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-warm btn-sm text-nowrap">{{ __('mobile.check_in') }}</button>
                                </form>
                            @endif

                            @if (in_array($booking->status, ['confirmed', 'waiting_list']) && !$isPast)
                                @if ($canCancel)
                                <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap"
                                    data-bs-toggle="modal" data-bs-target="#cancelModal"
                                    data-action="{{ route('class-bookings.cancel', $booking->uuid) }}"
                                    data-title="{{ $class?->name ?? 'Class' }} · {{ $booking->booking_date?->format('d M Y') }}">
                                    {{ __('mobile.cancel') }}
                                </button>
                                @else
                                <span class="m-micro text-muted2 text-nowrap">{{ __('mobile.cancel_closed') }}</span>
                                @endif
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
                        {{ $tab === 'upcoming' ? __('mobile.no_upcoming_bookings') : __('mobile.no_past_bookings') }}
                    </p>
                    <p class="mb-0 text-muted2 text-small">
                        {{ __('mobile.bookings_empty_desc') }}
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
                    <a href="{{ $bookings->previousPageUrl() }}" class="filter d-inline-block text-decoration-none">{{ __('mobile.newer') }}</a>
                @endif
                <span class="text-muted2" style="font-size:12px">
                    {{ __('mobile.page_of', ['current' => $bookings->currentPage(), 'last' => $bookings->lastPage()]) }}
                </span>
                @if ($bookings->hasMorePages())
                    <a href="{{ $bookings->nextPageUrl() }}" class="filter d-inline-block text-decoration-none">{{ __('mobile.older') }}</a>
                @else
                    <span></span>
                @endif
            </div>
        @endif

        <div style="height: 24px"></div>
    </div>
</section>

{{-- RATE MODAL --}}
<div class="modal fade" id="rateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body p-4 text-center">
                <span class="chip bg-sage-soft text-sage text-uppercase m-micro">{{ __('mobile.feedback') }}</span>
                <h5 class="fw-bold mt-2 mb-1" data-rate-title>{{ __('mobile.rate_title') }}</h5>
                <p class="text-muted2 m-micro mb-3">{{ __('mobile.rate_subtitle') }}</p>
                <form id="rateForm" method="POST">
                    @csrf
                    <div class="d-flex justify-content-center gap-2 mb-3" role="radiogroup" aria-label="Rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <label class="rate-star" style="cursor:pointer;font-size:30px;color:#cfd5cd;">
                                <input type="radio" name="rating" value="{{ $i }}" class="d-none" {{ $i === 5 ? 'checked' : '' }}>
                                <i class="bi bi-star-fill"></i>
                            </label>
                        @endfor
                    </div>
                    <textarea name="rating_comment" class="form-control mb-3" rows="2" maxlength="500"
                        placeholder="{{ __('mobile.rate_placeholder') }}"></textarea>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border flex-fill" data-bs-dismiss="modal">{{ __('mobile.cancel') }}</button>
                        <button type="submit" class="btn btn-warm flex-fill">{{ __('mobile.send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- CANCEL BOTTOM-SHEET --}}
<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="position:fixed;bottom:0;left:50%;transform:translateX(-50%);width:100%;max-width:430px;margin:0;">
        <div class="modal-content border-0" style="border-radius:24px 24px 0 0;">
            <div class="modal-body p-4 text-center">
                <div class="mx-auto mb-3 rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center"
                    style="width:56px;height:56px;">
                    <i class="bi bi-calendar-x text-danger fs-4"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ __('mobile.cancel_booking_confirm') }}</h5>
                <p class="text-muted2 small mb-4" data-cancel-title></p>
                <form id="cancelForm" method="POST">
                    @csrf
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light border flex-fill" data-bs-dismiss="modal">
                            {{ __('mobile.keep_booking') }}
                        </button>
                        <button type="submit" class="btn btn-danger flex-fill">
                            {{ __('mobile.yes_cancel') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- QR Modal --}}
<div class="modal fade" id="bookingQrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body p-4 text-center">
                <span class="chip bg-sage-soft text-sage text-uppercase m-micro">{{ __('mobile.qr_title') }}</span>
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
        var cancelModal = document.getElementById('cancelModal');
        if (cancelModal) {
            var cancelForm = document.getElementById('cancelForm');
            cancelModal.addEventListener('show.bs.modal', function (e) {
                var btn = e.relatedTarget;
                if (btn) {
                    cancelForm.action = btn.getAttribute('data-action') || '';
                    var title = btn.getAttribute('data-title');
                    if (title) cancelModal.querySelector('[data-cancel-title]').textContent = title;
                }
            });
        }
        var rateModal = document.getElementById('rateModal');
        if (rateModal) {
            var form = document.getElementById('rateForm');
            var stars = rateModal.querySelectorAll('.rate-star');
            function paint() {
                var checked = rateModal.querySelector('input[name="rating"]:checked');
                var val = checked ? parseInt(checked.value, 10) : 0;
                stars.forEach(function (label, idx) {
                    label.style.color = idx < val ? '#e0a100' : '#cfd5cd';
                });
            }
            stars.forEach(function (label) {
                label.querySelector('input').addEventListener('change', paint);
            });
            rateModal.addEventListener('show.bs.modal', function (e) {
                var btn = e.relatedTarget;
                if (btn) {
                    form.action = btn.getAttribute('data-action') || '';
                    var title = btn.getAttribute('data-title');
                    if (title) rateModal.querySelector('[data-rate-title]').textContent = title;
                }
                paint();
            });
        }
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

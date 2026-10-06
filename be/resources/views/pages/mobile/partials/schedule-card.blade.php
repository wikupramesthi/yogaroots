{{-- Kartu jadwal member (dipakai halaman Schedules).
  Variabel: $schedule, $bookingDate, $showDate (bool).
  Mengandalkan dari parent: $myBookings, $activePackage.
--}}
@php
$booked = $schedule->bookings_count ?? 0;
$remaining = max(0, ($schedule->capacity ?? 0) - $booked);

$class = $schedule->class;
$instructor = $class?->instructor;

$start = \Carbon\Carbon::parse($schedule->start_time);
$end = \Carbon\Carbon::parse($schedule->end_time);

$avatar = $instructor?->avatar
    ? (Str::startsWith($instructor->avatar, ['http://', 'https://'])
        ? $instructor->avatar
        : asset('storage/' . $instructor->avatar))
    : asset('dist/assets/images/avatar.jpg');

$myBooking = ($myBookings ?? collect())->get($schedule->uuid . '|' . $bookingDate);
@endphp

<div class="app-card p-3 overflow-hidden">
    <div class="d-flex align-items-center gap-3">
        <div class="flex-shrink-0">
            <img src="{{ $avatar }}"
                alt="{{ $instructor?->name ?? 'Instructor' }}"
                class="rounded-circle"
                loading="lazy"
                decoding="async"
                style="width:56px;height:56px;object-fit:cover;">
        </div>

        <div class="flex-fill" style="min-width:0;">
            <p class="mb-1 small fw-semibold text-truncate">
                {{ $class?->name ?? 'Class unavailable' }}
            </p>
            <p class="mb-1 text-muted2 text-truncate text-small">
                <i class="bi bi-person me-1"></i>
                {{ $instructor?->name ?? 'No Instructor' }}
                @if ($class?->level)
                    <span class="mx-1">•</span>
                    <i class="bi bi-bar-chart me-1"></i>
                    {{ __('mobile.level.' . $class->level) }}
                @endif
            </p>
            <p class="mb-0 text-muted2 text-truncate text-small">
                <i class="bi bi-calendar3 me-1"></i>
                @if (!empty($showDate))
                    {{ \Carbon\Carbon::parse($bookingDate)->translatedFormat('d M Y') }}
                    <span class="mx-1">•</span>
                @else
                    {{ __('mobile.day.' . strtolower($schedule->day)) }}
                    <span class="mx-1">•</span>
                @endif
                <i class="bi bi-clock me-1"></i>
                {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
            </p>
        </div>

        <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
            @if ($remaining <= 0 && empty($myBooking))
                <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis text-nowrap">{{ __('mobile.full') }}</span>
            @elseif ($remaining <= 3)
                <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis text-nowrap">{{ __('mobile.slots_left', ['count' => $remaining]) }}</span>
            @else
                <span class="badge rounded-pill bg-secondary-subtle text-secondary-emphasis text-nowrap">{{ __('mobile.slots_left', ['count' => $remaining]) }}</span>
            @endif

            @if ($myBooking && $myBooking->status === 'attended')
                <span class="badge rounded-pill bg-success-subtle text-success-emphasis">{{ __('mobile.done') }}</span>
            @elseif ($myBooking && $myBooking->status === 'waiting_list')
                <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis">{{ __('mobile.waiting') }}</span>
            @elseif ($myBooking && $myBooking->status === 'confirmed')
                @if ($bookingDate === now()->format('Y-m-d'))
                    <form action="{{ route('class-bookings.checkin', $myBooking->uuid) }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-warm btn-sm text-nowrap">{{ __('mobile.check_in') }}</button>
                    </form>
                @else
                    <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">{{ __('mobile.booked') }}</span>
                @endif
            @elseif (!empty($activePackage))
                @if ($bookingDate === now()->format('Y-m-d'))
                    <form action="{{ route('class-bookings.store') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="class_schedule_uuid" value="{{ $schedule->uuid }}">
                        <input type="hidden" name="booking_date" value="{{ $bookingDate }}">
                        <input type="hidden" name="checkin" value="1">
                        <button type="submit" class="btn btn-warm btn-sm text-nowrap">{{ $remaining <= 0 ? __('mobile.waitlist') : __('mobile.book_and_in') }}</button>
                    </form>
                @else
                    <form action="{{ route('class-bookings.store') }}" method="POST" class="m-0">
                        @csrf
                        <input type="hidden" name="class_schedule_uuid" value="{{ $schedule->uuid }}">
                        <input type="hidden" name="booking_date" value="{{ $bookingDate }}">
                        <button type="submit" class="btn btn-warm btn-sm text-nowrap">{{ $remaining <= 0 ? __('mobile.waitlist') : __('mobile.book') }}</button>
                    </form>
                @endif
            @else
                <a href="{{ route('packages.member') }}" class="btn btn-sm btn-outline-secondary text-nowrap">{{ __('mobile.view_plans') }}</a>
            @endif
        </div>
    </div>
</div>

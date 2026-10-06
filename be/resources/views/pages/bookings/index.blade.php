@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="My Bookings" page="Classes" active="My Bookings"
        route="{{ route('bookings.my') }}" />
@endsection

<section class="section">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible mb-3 fade show" role="alert">
            <span class="alert-text text-white">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">My Bookings</h5>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($bookings->total()) }} bookings</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('bookings.my', ['tab' => 'upcoming']) }}"
                    class="btn btn-sm {{ $tab === 'upcoming' ? 'btn-primary' : 'btn-light' }}">Upcoming</a>
                <a href="{{ route('bookings.my', ['tab' => 'past']) }}"
                    class="btn btn-sm {{ $tab === 'past' ? 'btn-primary' : 'btn-light' }}">Past</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table security-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Instructor</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            @php
                                $schedule = $booking->schedule;
                                $class = $schedule?->class;
                                $isToday = $booking->booking_date?->format('Y-m-d') === now()->format('Y-m-d');
                                $isPast = $booking->booking_date?->format('Y-m-d') < now()->format('Y-m-d');
                                $start = $schedule ? \Carbon\Carbon::parse($schedule->start_time) : null;
                                $classAt = ($booking->booking_date && $start)
                                    ? $booking->booking_date->copy()->setTime($start->hour, $start->minute)
                                    : null;
                                $canCancel = $booking->status === 'waiting_list'
                                    ? ! $isPast
                                    : ($classAt && $classAt->greaterThan(now()->addHours(2)));
                                $statusBadge = match ($booking->status) {
                                    'attended' => 'bg-success-subtle text-success',
                                    'waiting_list' => 'bg-warning-subtle text-warning',
                                    'confirmed' => 'bg-primary-subtle text-primary',
                                    default => 'bg-secondary-subtle text-secondary',
                                };
                            @endphp
                            <tr>
                                <td class="fw-semibold text-nowrap">{{ $booking->booking_date?->format('d M Y') ?? '-' }}</td>
                                <td>{{ $class?->name ?? 'Class unavailable' }}</td>
                                <td>{{ $class?->instructor?->name ?? '-' }}</td>
                                <td class="text-nowrap">
                                    {{ $start?->format('H:i') ?? '-' }}–{{ $schedule ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '-' }}
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $statusBadge }}">{{ ucfirst($booking->status) }}</span>
                                    @if ($booking->status === 'waiting_list' && isset($waitingPositions[$booking->uuid]))
                                        <small class="d-block text-muted">#{{ $waitingPositions[$booking->uuid] }} in line</small>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end flex-wrap">
                                        @if ($booking->status === 'confirmed' && $isToday)
                                            <form action="{{ route('class-bookings.checkin', $booking->uuid) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Check In</button>
                                            </form>
                                        @endif
                                        @if ($booking->status === 'attended' && $tab === 'past')
                                            @if (is_null($booking->rating))
                                                <form action="{{ route('class-bookings.rate', $booking->uuid) }}" method="POST" class="d-flex gap-1 align-items-center">
                                                    @csrf
                                                    <select name="rating" class="form-select form-select-sm" style="width:auto;" required>
                                                        <option value="5">★★★★★</option>
                                                        <option value="4">★★★★</option>
                                                        <option value="3">★★★</option>
                                                        <option value="2">★★</option>
                                                        <option value="1">★</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Rate</button>
                                                </form>
                                            @else
                                                <span class="text-warning text-nowrap" title="Rated {{ $booking->rating }} of 5">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi {{ $i <= $booking->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                    @endfor
                                                </span>
                                            @endif
                                        @endif
                                        @if (in_array($booking->status, ['confirmed', 'waiting_list']) && !$isPast)
                                            @if ($canCancel)
                                                <form action="{{ route('class-bookings.cancel', $booking->uuid) }}" method="POST"
                                                    onsubmit="return confirm('Cancel this booking?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                                </form>
                                            @else
                                                <small class="text-muted">Cancel closed</small>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No {{ $tab }} bookings.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($bookings->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</section>

@endsection

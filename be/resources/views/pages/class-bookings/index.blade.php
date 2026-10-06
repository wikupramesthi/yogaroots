@extends('layouts.app')

@section('title', 'Class Bookings')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Bookings" page="Memberships" active="Bookings"
        route="{{ route('class-bookings.index') }}" />
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

    @if ($isAdmin)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Manual Check-in</h5>
                <p class="text-muted small mb-0">Check in a member who attended without checking in via the system. Quota is consumed automatically.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('class-bookings.directCheckin') }}"
                    class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label class="security-filter-label" for="directUser">Member</label>
                        <select name="user_uuid" id="directUser" class="form-select" required>
                            <option value="">Select member...</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->user_uuid }}">
                                    {{ $member->user?->name ?? '-' }}
                                    ({{ is_null($member->quota) ? 'Unlimited' : $member->quota . ' left' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="security-filter-label" for="directSchedule">Class Schedule</label>
                        <select name="class_schedule_uuid" id="directSchedule" class="form-select" required>
                            <option value="">Select schedule...</option>
                            @foreach ($schedules as $schedule)
                            <option value="{{ $schedule->uuid }}" data-day="{{ strtolower($schedule->day) }}">
                                {{ $schedule->class?->name ?? '-' }} —
                                {{ ucfirst($schedule->day) }}
                                {{ substr((string) $schedule->start_time, 0, 5) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="security-filter-label" for="directDate">Session Date</label>
                        <input type="date" name="booking_date" id="directDate" class="form-control"
                            value="{{ now()->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check2-circle me-1"></i>Check In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        (function () {
            const scheduleSelect = document.getElementById('directSchedule');
            const dateInput = document.getElementById('directDate');
            if (!scheduleSelect || !dateInput) return;

            const dayIndex = { sunday: 0, monday: 1, tuesday: 2, wednesday: 3, thursday: 4, friday: 5, saturday: 6 };

            scheduleSelect.addEventListener('change', function () {
                const opt = scheduleSelect.options[scheduleSelect.selectedIndex];
                const target = dayIndex[opt.dataset.day];
                if (target === undefined) return;

                const d = new Date();
                d.setHours(0, 0, 0, 0);
                while (d.getDay() !== target) d.setDate(d.getDate() - 1);
                const yyyy = d.getFullYear();
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                const dd = String(d.getDate()).padStart(2, '0');

                dateInput.value = `${yyyy}-${mm}-${dd}`;
            });
        })();
    </script>

    <div class="card ml-toolbar security-toolbar mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('class-bookings.index') }}"
                class="security-filter-form d-flex flex-wrap align-items-end gap-3">
                @if ($isAdmin)
                    <div>
                        <label class="security-filter-label" for="filterSearch">Search</label>
                        <input type="text" name="search" id="filterSearch" class="form-control"
                            placeholder="Name or email..." value="{{ $filters['search'] ?? '' }}" style="min-width: 200px;">
                    </div>
                @endif
                <div>
                    <label class="security-filter-label" for="filterStatus">Status</label>
                    <select name="status" id="filterStatus" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach (['confirmed', 'waiting_list', 'attended', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="security-filter-label" for="filterDate">Session Date</label>
                    <input type="date" name="date" id="filterDate" class="form-control"
                        value="{{ $filters['date'] ?? '' }}">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('class-bookings.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">
                    @if ($isAdmin)
                        All Bookings
                    @else
                        My Bookings
                    @endif
                </h5>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($bookings->total()) }}
                    bookings</span>
            </div>
            @if ($isAdmin)
                <a href="{{ route('class-bookings.scan') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-qr-code-scan me-1"></i> Scan Check-in
                </a>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table security-table">
                    <thead>
                        <tr>
                            @if ($isAdmin)
                                <th>Member</th>
                            @endif
                            <th>Class</th>
                            <th>Schedule</th>
                            <th>Session</th>
                            <th>Status</th>
                            <th>Booked</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($bookings as $booking)
                            <tr>
                                @if ($isAdmin)
                                    <td>
                                        <span class="d-block fw-semibold">{{ $booking->user?->name ?? '-' }}</span>
                                        <small class="log-muted">{{ $booking->user?->email ?? '-' }}</small>
                                    </td>
                                @endif
                                <td class="fw-semibold">{{ $booking->schedule?->class?->name ?? '-' }}</td>
                                <td>
                                    <span class="d-block">{{ ucfirst($booking->schedule?->day ?? '-') }}</span>
                                    <small class="log-muted">
                                        {{ substr((string) $booking->schedule?->start_time, 0, 5) }}–{{ substr((string) $booking->schedule?->end_time, 0, 5) }}
                                        • {{ $booking->schedule?->studio?->name ?? '' }}
                                    </small>
                                </td>
                                <td>
                                    <span class="d-block fw-semibold">{{ $booking->booking_date?->format('d M Y') ?? '-' }}</span>
                                    <small class="log-muted">{{ $booking->booking_date?->format('l') ?? '' }}</small>
                                </td>
                                <td>
                                    @if ($booking->status === 'attended')
                                        <span class="badge bg-success-subtle text-success">Attended</span>
                                    @elseif ($booking->status === 'confirmed')
                                        <span class="badge bg-primary-subtle text-primary">Confirmed</span>
                                    @elseif ($booking->status === 'waiting_list')
                                        <span class="badge bg-warning-subtle text-warning">Waiting List</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $booking->booked_at?->format('d M Y') ?? '-' }}</span>
                                    <small class="log-muted">{{ $booking->booked_at?->format('H:i') ?? '' }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        @if ($booking->status === 'attended')
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                data-bs-toggle="modal" data-bs-target="#modal-checkin-{{ $booking->uuid }}">
                                                <i class="bi bi-info-circle"></i> Detail Check-in
                                            </button>
                                        @endif
                                        @if ($booking->status === 'confirmed')
                                            <form action="{{ route('class-bookings.checkin', $booking->uuid) }}"
                                                method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Check in">
                                                    <i class="bi bi-check2-circle"></i> Check In
                                                </button>
                                            </form>
                                        @endif
                                        @if (in_array($booking->status, ['confirmed', 'waiting_list'], true))
                                            <form action="{{ route('class-bookings.cancel', $booking->uuid) }}"
                                                method="POST" class="m-0"
                                                onsubmit="return confirm('Cancel this booking?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 7 : 6 }}" class="text-center text-muted py-4">
                                    <i class="bi bi-calendar-check fs-3 d-block mb-2"></i>
                                    No bookings found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($bookings->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                    <div class="text-muted small">
                        Showing <strong>{{ $bookings->firstItem() }}</strong> –
                        <strong>{{ $bookings->lastItem() }}</strong> of
                        <strong>{{ $bookings->total() }}</strong> bookings
                    </div>
                    <div>{{ $bookings->links() }}</div>
                </div>
            @endif
        </div>
    </div>
</section>

@foreach ($bookings as $booking)
    @if ($booking->status === 'attended')
        <div class="modal fade" id="modal-checkin-{{ $booking->uuid }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check-in Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mb-0">
                            @if ($isAdmin)
                                <dt class="col-sm-4">Member</dt>
                                <dd class="col-sm-8">{{ $booking->user?->name ?? '-' }}</dd>
                            @endif
                            <dt class="col-sm-4">Class</dt>
                            <dd class="col-sm-8">{{ $booking->schedule?->class?->name ?? '-' }}</dd>
                            <dt class="col-sm-4">Schedule</dt>
                            <dd class="col-sm-8">{{ ucfirst($booking->schedule?->day ?? '-') }} {{ substr((string) $booking->schedule?->start_time, 0, 5) }}</dd>
                            <dt class="col-sm-4">Session Date</dt>
                            <dd class="col-sm-8">{{ $booking->booking_date?->format('d M Y') ?? '-' }}</dd>
                            <dt class="col-sm-4">Checked In At</dt>
                            <dd class="col-sm-8">{{ $booking->attended_at?->format('d M Y H:i') ?? '-' }}</dd>
                            <dt class="col-sm-4">Quota Used</dt>
                            <dd class="col-sm-8">{{ $booking->quota_used ?? 0 }}</dd>
                            <dt class="col-sm-4">Booking Type</dt>
                            <dd class="col-sm-8">{{ ucfirst($booking->booking_type ?? '-') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@endsection

@extends('layouts.app')

@section('title', 'Member Detail')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Member Detail" page="Memberships" active="Detail"
        route="{{ route('memberships.index') }}" />
@endsection

<section class="section">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Membership</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar avatar-xl">
                            <span class="avatar-initial rounded-circle bg-primary">
                                {{ strtoupper(substr($membership->user?->name ?? '?', 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $membership->user?->name ?? '-' }}</h5>
                            <small class="log-muted">{{ $membership->user?->email ?? '-' }}</small>
                        </div>
                    </div>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Package</dt>
                        <dd class="col-sm-8 fw-semibold">{{ $membership->package?->name ?? '-' }}</dd>

                        <dt class="col-sm-4">Quota left</dt>
                        <dd class="col-sm-8">
                            @if (is_null($membership->quota))
                                <span class="badge bg-info-subtle text-info">Unlimited</span>
                            @else
                                <strong>{{ $membership->quota }}</strong> classes
                            @endif
                        </dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            @if ($membership->status === 'active')
                                <span class="badge bg-success-subtle text-success">Active</span>
                            @elseif ($membership->status === 'expired')
                                <span class="badge bg-secondary-subtle text-secondary">Expired</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Started</dt>
                        <dd class="col-sm-8">{{ $membership->started_at?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-4">Expires</dt>
                        <dd class="col-sm-8">{{ $membership->expired_at?->format('d M Y H:i') ?? '-' }}</dd>

                        <dt class="col-sm-4">Order</dt>
                        <dd class="col-sm-8">
                            @if ($membership->order)
                                <a href="{{ route('orders.show', $membership->order->uuid) }}">
                                    {{ $membership->order->order_number }}
                                </a>
                                <small class="log-muted d-block">{{ $membership->order->packageOption?->name ?? '' }}</small>
                            @else
                                <span class="log-muted">-</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h5 class="card-title mb-0">Booking History</h5>
                    <span class="badge bg-primary-subtle text-primary">{{ $bookings->count() }} bookings</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table security-table mb-0">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Schedule</th>
                                    <th>Status</th>
                                    <th>Booked</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($bookings as $booking)
                                    <tr>
                                        <td class="fw-semibold">{{ $booking->schedule?->class?->name ?? '-' }}</td>
                                        <td>
                                            <span class="d-block fw-semibold">{{ $booking->booking_date?->format('d M Y') ?? '-' }}</span>
                                            <small class="log-muted">
                                                {{ ucfirst($booking->schedule?->day ?? '-') }},
                                                {{ substr((string) $booking->schedule?->start_time, 0, 5) }}–{{ substr((string) $booking->schedule?->end_time, 0, 5) }}
                                            </small>
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
                                            <small>{{ $booking->booked_at?->format('d M Y H:i') ?? '-' }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No bookings yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

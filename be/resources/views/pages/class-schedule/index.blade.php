@extends('layouts.app')
@section('title', 'Schedule')

@section('breadcrumb')
<x-breadcrumb title="Schedule" page="Class" active="Schedule" route="{{ route('class-schedules.index') }}" />
@endsection

@section('content')

<style>
.schedule-wrapper { width: 100%; overflow-x: auto; }
.schedule-grid { display: grid; grid-template-columns: repeat(7, minmax(150px, 1fr)); gap: 4px; min-width: 1100px; }
.schedule-column { min-height: 500px; background: #f8f8f8; border-radius: 10px; overflow: hidden; padding-bottom: 8px; }
.schedule-day { background: #566052; color: #fff; text-align: center; padding: 14px 8px; font-weight: 600; font-size: 14px; }
.schedule-items { display: flex; flex-direction: column; gap: 4px; padding: 4px; }
.schedule-card { padding: 12px 8px; min-height: 105px; border-radius: 10px; text-align: center; cursor: pointer; transition: .2s ease; border: 1px solid transparent; }
.schedule-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, .12); }
.schedule-card.foundation { background: #e5dfd1; color: #444; }
.schedule-card.intermediate { background: #a99c8c; color: #fff; }
.schedule-card.advance { background: #bd5937; color: #fff; }
.schedule-time { font-weight: 700; font-size: 13px; }
.schedule-class { font-size: 13px; font-weight: 500; margin-top: 3px; }
.schedule-duration { font-size: 12px; opacity: .85; }
.schedule-instructor { font-size: 12px; margin-top: 2px; }
.schedule-studio { font-size: 12px; margin-top: 2px; opacity: .85; }
.schedule-empty { text-align: center; color: #aaa; font-size: 12px; padding: 20px 5px; }
.schedule-legend { width: 18px; height: 18px; border-radius: 50%; display: inline-block; }
.schedule-legend.foundation { background: #e5dfd1; }
.schedule-legend.intermediate { background: #a99c8c; }
.schedule-legend.advance { background: #bd5937; }
</style>

<section class="section">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    @endif

    @if (!empty($isMember) && empty($activePackage) && empty($pendingOrder))
        <div class="alert alert-warning d-flex align-items-center gap-3 mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-4 flex-shrink-0"></i>
            <div class="flex-fill">
                <strong class="text-dark">You don't have an active membership yet.</strong>
                <span class="d-block">Choose a package and complete the payment first — you can check in after admin approves your order.</span>
            </div>
            <a href="{{ route('packages.member') }}" class="btn btn-sm btn-warning fw-bold flex-shrink-0">
                <i class="bi bi-credit-card me-1"></i>Choose Package &amp; Pay
            </a>
        </div>
    @elseif (!empty($isMember) && empty($activePackage) && !empty($pendingOrder))
        <div class="alert alert-info d-flex align-items-center gap-3 mt-3" role="alert">
            <i class="bi bi-hourglass-split fs-4 flex-shrink-0"></i>
            <div class="flex-fill">
                <strong class="text-dark">Payment waiting for admin verification.</strong>
                <span class="d-block">
                    Order {{ $pendingOrder->order_number }}
                    @if ($pendingOrder->proof_image_path)
                        — proof uploaded, please wait.
                    @else
                        — upload your transfer proof so admin can approve it.
                    @endif
                    You can check in after approval.
                </span>
            </div>
            <a href="{{ route('orders.show', $pendingOrder->uuid) }}" class="btn btn-sm btn-info fw-bold flex-shrink-0">
                @if ($pendingOrder->proof_image_path)
                    <i class="bi bi-eye me-1"></i>View Order
                @else
                    <i class="bi bi-upload me-1"></i>Upload Proof
                @endif
            </a>
        </div>
    @elseif (!empty($isMember) && !empty($activePackage))
        <div class="alert alert-success d-flex align-items-center gap-3 mt-3" role="alert">
            <i class="bi bi-check-circle-fill fs-4 flex-shrink-0"></i>
            <div class="flex-fill">
                <strong>Membership active</strong>
                <span>
                    until {{ $activePackage->expired_at?->format('d M Y') ?? '-' }}
                    @if (is_null($activePackage->quota))
                        (Unlimited)
                    @else
                        ({{ $activePackage->quota }} classes left)
                    @endif
                    — you can book and check in to classes.
                </span>
            </div>
            <a href="{{ route('class-bookings.index') }}" class="btn btn-sm btn-success fw-bold flex-shrink-0">
                <i class="bi bi-calendar-check me-1"></i>My Bookings
            </a>
        </div>
    @endif

    {{-- Statistic cards follow the active filter --}}
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-primary"><i class="bx bx-calendar"></i></div><div><div class="ml-stat-value">{{ number_format($stats['total']) }}</div><div class="ml-stat-label">Total Schedules</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-success"><i class="bx bx-calendar-check"></i></div><div><div class="ml-stat-value">{{ number_format($stats['monday_friday']) }}</div><div class="ml-stat-label">Weekdays</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-warning"><i class="bx bx-sun"></i></div><div><div class="ml-stat-value">{{ number_format($stats['weekend']) }}</div><div class="ml-stat-label">Weekend</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-violet"><i class="bx bx-building"></i></div><div><div class="ml-stat-value">{{ number_format($stats['studios']) }}</div><div class="ml-stat-label">Studios</div></div></div></div></div></div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form method="GET" action="{{ route('class-schedules.index') }}" class="d-flex flex-wrap align-items-end gap-2">
                    <div><label class="form-label small mb-0">Search</label><input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Class name..." style="min-width:170px;" autocomplete="off"></div>
                    <div><label class="form-label small mb-0">Day</label>
                        <select name="day" class="form-select form-select-sm" style="min-width:140px;">
                            <option value="">All</option>
                            @foreach (['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $d)
                            <option value="{{ $d }}" @selected($day === $d)>{{ ucfirst($d) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label class="form-label small mb-0">Studio</label>
                        <select name="studio_uuid" class="form-select form-select-sm" style="min-width:160px;">
                            <option value="">All</option>
                            @foreach ($studios as $studio)
                            <option value="{{ $studio->uuid }}" @selected($studioUuid === $studio->uuid)>{{ $studio->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-1"><button type="submit" class="btn btn-sm btn-success"><i class="bi bi-funnel"></i> Filter</button><a href="{{ route('class-schedules.index') }}" class="btn btn-sm btn-light">Reset</a></div>
                </form>
                @can('class-schedules.store')
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form-add-class-schedule">
                    <i class="bi bi-plus-lg"></i> Add Schedule
                </button>
                @endcan
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0">Class Schedule</h6>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($stats['total']) }} schedules</span>
            </div>
            <div class="d-flex gap-4 flex-wrap small">
                <div class="d-flex align-items-center gap-2"><span class="schedule-legend foundation"></span><span>Foundation</span></div>
                <div class="d-flex align-items-center gap-2"><span class="schedule-legend intermediate"></span><span>Intermediate</span></div>
                <div class="d-flex align-items-center gap-2"><span class="schedule-legend advance"></span><span>Advance</span></div>
            </div>
        </div>

        <div class="card-body">
            <div class="schedule-wrapper">
                @php
                    $dayNames = [
                        'monday' => 'MONDAY',
                        'tuesday' => 'TUESDAY',
                        'wednesday' => 'WEDNESDAY',
                        'thursday' => 'THURSDAY',
                        'friday' => 'FRIDAY',
                        'saturday' => 'SATURDAY',
                        'sunday' => 'SUNDAY',
                    ];
                @endphp

                <div class="schedule-grid">
                    @foreach ($dayNames as $d => $dayName)
                    <div class="schedule-column">
                        <div class="schedule-day">{{ $dayName }}</div>
                        <div class="schedule-items">
                            @forelse ($schedules->where('day', $d)->sortBy('start_time') as $schedule)
                            @php
                                $level = $schedule->class->level ?? 'foundation';
                            @endphp
                            <div class="schedule-card {{ $level }}" data-bs-toggle="modal" data-bs-target="#modal-schedule-{{ $schedule->uuid }}">
                                <div class="schedule-time">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H.i') }}
                                    @if ($schedule->end_time)
                                    - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H.i') }}
                                    @endif
                                </div>
                                <div class="schedule-class">{{ $schedule->class->name }}</div>
                                <div class="schedule-duration">
                                    @if ($schedule->end_time)
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->end_time)) }} min
                                    @endif
                                </div>
                                <div class="schedule-instructor">{{ $schedule->class->instructor->name ?? '-' }}</div>
                                <div class="schedule-studio"><i class="bi bi-geo-alt me-1"></i>{{ $schedule->studio->name ?? '-' }}</div>
                            </div>
                            @empty
                            <div class="schedule-empty">No class</div>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Content -->

@include('pages.class-schedule.modal-create')
@include('pages.class-schedule.modal-detail')

@endsection

@extends('layouts.app')

@section('title', 'Memberships')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Memberships" page="Memberships" active="All Members"
        route="{{ route('memberships.index') }}" />
@endsection

<section class="section">
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-primary"><i class="bx bx-id-card"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['total']) }}</div>
                            <div class="ml-stat-label">Total Memberships</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-success"><i class="bx bx-check-circle"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['active']) }}</div>
                            <div class="ml-stat-label">Active</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-warning"><i class="bx bx-time-five"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['expiring']) }}</div>
                            <div class="ml-stat-label">Expiring ≤ 7 Days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-secondary"><i class="bx bx-archive"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats['expired']) }}</div>
                            <div class="ml-stat-label">Expired</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ml-toolbar security-toolbar mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('memberships.index') }}"
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
                        @foreach (['active', 'expired', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="security-filter-label" for="filterExpiring">Expiring</label>
                    <select name="expiring" id="filterExpiring" class="form-select">
                        <option value="">All</option>
                        <option value="7days" @selected(($filters['expiring'] ?? '') === '7days')>Within 7 days</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('memberships.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">All Members</h5>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($memberships->total()) }}
                    members</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <p class="text-muted small mb-0 d-none d-md-block">Members who purchased a membership package.</p>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table security-table">
                    <thead>
                        <tr>
                            @if ($isAdmin)
                                <th>Member</th>
                            @endif
                            <th>Package</th>
                            <th class="text-center">Quota Left</th>
                            <th>Started</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($memberships as $membership)
                            <tr>
                                @if ($isAdmin)
                                    <td>
                                        <span class="d-block fw-semibold">{{ $membership->user?->name ?? '-' }}</span>
                                        <small class="log-muted">{{ $membership->user?->email ?? '-' }}</small>
                                    </td>
                                @endif
                                <td>
                                    <span class="d-block fw-semibold">{{ $membership->package?->name ?? '-' }}</span>
                                    <small class="log-muted">{{ $membership->order?->order_number ?? '-' }}</small>
                                </td>
                                <td class="text-center">
                                    @if (is_null($membership->quota))
                                        <span class="badge bg-info-subtle text-info">Unlimited</span>
                                    @elseif ($membership->quota > 0)
                                        <span class="fw-bold">{{ $membership->quota }}</span>
                                        <small class="log-muted">left</small>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Empty</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $membership->started_at?->format('d M Y') ?? '-' }}</span>
                                </td>
                                <td>
                                    @if ($membership->expired_at)
                                        <span class="d-block">{{ $membership->expired_at->format('d M Y') }}</span>
                                        <small class="log-muted">{{ $membership->expired_at->diffForHumans() }}</small>
                                    @else
                                        <span class="log-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($membership->status === 'active')
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @elseif ($membership->status === 'expired')
                                        <span class="badge bg-secondary-subtle text-secondary">Expired</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('memberships.show', $membership->uuid) }}"
                                        class="btn btn-sm btn-outline-primary" title="View detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 7 : 6 }}" class="text-center text-muted py-4">
                                    <i class="bi bi-people fs-3 d-block mb-2"></i>
                                    No memberships found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($memberships->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                    <div class="text-muted small">
                        Showing <strong>{{ $memberships->firstItem() }}</strong> –
                        <strong>{{ $memberships->lastItem() }}</strong> of
                        <strong>{{ $memberships->total() }}</strong> memberships
                    </div>
                    <div>{{ $memberships->links() }}</div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection

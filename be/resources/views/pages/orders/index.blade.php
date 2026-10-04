@extends('layouts.app')

@section('title', 'Billing')

@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Billing" page="Orders" active="Billing"
        route="{{ route('orders.index') }}" />
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

    <div class="row g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-primary"><i class="bx bx-receipt"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats->total ?? 0) }}</div>
                            <div class="ml-stat-label">Total Orders</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-warning"><i class="bx bx-hourglass"></i></div>
                        <div>
                            <div class="ml-stat-value">{{ number_format($stats->pending ?? 0) }}</div>
                            <div class="ml-stat-label">Pending</div>
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
                            <div class="ml-stat-value">{{ number_format($stats->paid ?? 0) }}</div>
                            <div class="ml-stat-label">Paid</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="card">
                <div class="card-body">
                    <div class="ml-stat">
                        <div class="ml-stat-icon ic-violet"><i class="bx bx-wallet"></i></div>
                        <div>
                            <div class="ml-stat-value">Rp {{ number_format($stats->revenue ?? 0, 0, ',', '.') }}</div>
                            <div class="ml-stat-label">Revenue (Paid)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ml-toolbar security-toolbar mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form method="GET" action="{{ route('orders.index') }}"
                    class="security-filter-form d-flex flex-wrap align-items-end gap-3">
                    @if ($isAdmin)
                        <div>
                            <label class="security-filter-label" for="filterSearch">Search</label>
                            <input type="text" name="search" id="filterSearch" class="form-control"
                                placeholder="Order no, name, email..." value="{{ $filters['search'] ?? '' }}" style="min-width: 200px;">
                        </div>
                    @endif
                    <div>
                        <label class="security-filter-label" for="filterStatus">Status</label>
                        <select name="status" id="filterStatus" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach (['pending', 'paid', 'failed', 'expired', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterType">Type</label>
                        <select name="type" id="filterType" class="form-select">
                            <option value="">All Types</option>
                            @foreach (['package', 'class'] as $type)
                                <option value="{{ $type }}" @selected(($filters['type'] ?? '') === $type)>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                <div>
                    <label class="security-filter-label" for="filterProof">Proof</label>
                    <select name="proof" id="filterProof" class="form-select">
                        <option value="">All</option>
                        <option value="uploaded" @selected(($filters['proof'] ?? '') === 'uploaded')>Uploaded</option>
                        <option value="missing" @selected(($filters['proof'] ?? '') === 'missing')>Not uploaded</option>
                    </select>
                </div>
                <div>
                    <label class="security-filter-label" for="filterStart">From Date</label>
                        <input type="date" name="start_date" id="filterStart" class="form-control"
                            value="{{ $filters['start_date'] ?? '' }}">
                    </div>
                    <div>
                        <label class="security-filter-label" for="filterEnd">To Date</label>
                        <input type="date" name="end_date" id="filterEnd" class="form-control"
                            value="{{ $filters['end_date'] ?? '' }}">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-light">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <h5 class="card-title mb-0">Order List</h5>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($orders->total()) }}
                    orders</span>
            </div>
            <div class="d-flex align-items-center gap-2 flex-shrink-0">
                <p class="text-muted small mb-0 d-none d-xl-block">
                    @if ($isAdmin)
                        All membership orders and payment status.
                    @else
                        Your membership orders and payment status.
                    @endif
                </p>
                <a href="{{ route('orders.report', request()->query()) }}" class="btn btn-sm btn-outline-secondary text-nowrap">
                    <i class="bi bi-file-text me-1"></i>Preview Report
                </a>
                <a href="{{ route('orders.exportPdf', request()->query()) }}" class="btn btn-sm btn-danger text-nowrap">
                    <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table security-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            @if ($isAdmin)
                                <th>Customer</th>
                            @endif
                            <th>Membership</th>
                            <th class="text-end">Amount</th>
                            <th>Status</th>
                            <th>Proof</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <span class="d-block fw-semibold">{{ $order->order_number }}</span>
                                    <small class="log-muted">{{ strtoupper($order->type) }}</small>
                                </td>
                                @if ($isAdmin)
                                    <td>
                                        <span class="d-block fw-semibold">{{ $order->user?->name ?? '-' }}</span>
                                        <small class="log-muted">{{ $order->user?->email ?? '-' }}</small>
                                    </td>
                                @endif
                                <td>
                                    <span class="d-block fw-semibold">{{ $order->package?->name ?? 'Single Class' }}</span>
                                    @if ($order->packageOption?->name)
                                        <small class="log-muted">{{ $order->packageOption->name }}</small>
                                    @endif
                                </td>
                                <td class="text-end fw-semibold">
                                    Rp {{ number_format($order->amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($order->status === 'paid')
                                        <span class="badge bg-success-subtle text-success">Paid</span>
                                    @elseif ($order->status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                    @elseif ($order->status === 'failed')
                                        <span class="badge bg-danger-subtle text-danger">Failed</span>
                                    @elseif ($order->status === 'expired')
                                        <span class="badge bg-secondary-subtle text-secondary">Expired</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->proof_image_path)
                                        <a href="{{ route('orders.show', $order->uuid) }}"
                                            class="badge bg-info-subtle text-info text-decoration-none"
                                            title="Uploaded {{ $order->proof_uploaded_at?->format('d M Y H:i') ?? '' }} — click to verify">
                                            <i class="bi bi-file-earmark-check me-1"></i>Uploaded
                                        </a>
                                    @else
                                        <span class="log-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-block">{{ $order->created_at?->format('d M Y') ?? '-' }}</span>
                                    <small class="log-muted">{{ $order->created_at?->format('H:i') ?? '' }}</small>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order->uuid) }}"
                                        class="btn btn-sm btn-outline-primary" title="View detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 8 : 7 }}" class="text-center text-muted py-4">
                                    <i class="bi bi-receipt fs-3 d-block mb-2"></i>
                                    No orders found. Try adjusting the filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                    <div class="text-muted small">
                        Showing <strong>{{ $orders->firstItem() }}</strong> –
                        <strong>{{ $orders->lastItem() }}</strong> of
                        <strong>{{ $orders->total() }}</strong> orders
                    </div>
                    <div>{{ $orders->links('pagination::bootstrap-5') }}</div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection

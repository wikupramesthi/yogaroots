@extends('layouts.app')

@section('title', 'Order Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold text-dark">Order Report</h4>
            <p class="mb-0 fw-semibold">
                Period: <strong>{{ $periode }}</strong>
                <span class="mx-1">•</span> {{ number_format($total) }} orders
                <span class="mx-1">•</span> Generated {{ $waktuCetak }}
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('orders.index', request()->query()) }}" class="btn btn-light">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <a href="{{ route('orders.exportPdf', request()->query()) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i> Download PDF
            </a>
            <button type="button" onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i> Print
            </button>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Total Orders</div>
                <div class="fs-4 fw-bold">{{ number_format($total) }}</div>
            </div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Pending</div>
                <div class="fs-4 fw-bold text-warning">{{ number_format($pendingCount) }}</div>
            </div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Paid</div>
                <div class="fs-4 fw-bold text-success">{{ number_format($paidCount) }}</div>
            </div></div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm"><div class="card-body">
                <div class="text-muted small">Revenue (Paid)</div>
                <div class="fs-5 fw-bold text-primary">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
            </div></div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3 d-flex flex-wrap align-items-center gap-3">
            <span class="d-inline-flex align-items-center gap-2 fw-bold text-dark">
                <i class="bi bi-funnel-fill text-primary"></i> Filters
            </span>
            <span>Status: <strong class="text-dark">{{ $filterStatus }}</strong></span>
            <span>Type: <strong class="text-dark">{{ $filterType }}</strong></span>
            @if (!empty($search))
                <span>Search: <strong class="text-dark">{{ $search }}</strong></span>
            @endif
            <span>Printed by <strong class="text-dark">{{ $dicetakOleh }}</strong></span>
        </div>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width:40px;">No</th>
                            <th>Date</th>
                            <th>Order No</th>
                            @if ($isAdmin)
                                <th>Customer</th>
                            @endif
                            <th>Membership</th>
                            <th class="text-end">Amount</th>
                            <th>Status</th>
                            <th>Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $i => $order)
                            <tr>
                                <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                                <td><small>{{ $order->created_at?->format('d M Y H:i') ?? '-' }}</small></td>
                                <td class="fw-semibold">{{ $order->order_number }}</td>
                                @if ($isAdmin)
                                    <td>
                                        <span class="d-block">{{ $order->user?->name ?? '-' }}</span>
                                        <small class="text-muted">{{ $order->user?->email ?? '-' }}</small>
                                    </td>
                                @endif
                                <td>
                                    <span class="d-block">{{ $order->package?->name ?? 'Single Class' }}</span>
                                    <small class="text-muted">{{ $order->packageOption?->name ?? '' }}</small>
                                </td>
                                <td class="text-end">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($order->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif ($order->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($order->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @elseif ($order->status === 'expired')
                                        <span class="badge bg-secondary">Expired</span>
                                    @else
                                        <span class="badge bg-secondary">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->proof_image_path)
                                        <span class="badge bg-info">Uploaded</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 8 : 7 }}" class="text-center text-muted py-5">
                                    No data for the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($orders->isNotEmpty())
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="{{ $isAdmin ? 6 : 5 }}" class="ps-4 fw-bold text-end">Total Revenue (Paid)</td>
                                <td class="text-end fw-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

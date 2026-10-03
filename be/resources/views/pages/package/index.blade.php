@extends('layouts.app')

@section('title', 'Packages')

@section('content')

@section('breadcrumb')
<x-breadcrumb
    title="Packages"
    page="Packages"
    active="All Packages"
    route="{{ route('packages.index') }}" />
@endsection

<section class="section">

    {{-- Alert --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white">
            {{ session('success') }}
        </span>

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white">
            {{ session('error') }}
        </span>

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- Statistic cards: numbers follow the active filter --}}
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-primary"><i class="bx bx-package"></i></div><div><div class="ml-stat-value">{{ number_format($stats['total']) }}</div><div class="ml-stat-label">Total Packages</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-success"><i class="bx bx-check-circle"></i></div><div><div class="ml-stat-value">{{ number_format($stats['active']) }}</div><div class="ml-stat-label">Active</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-warning"><i class="bx bx-pause-circle"></i></div><div><div class="ml-stat-value">{{ number_format($stats['inactive']) }}</div><div class="ml-stat-label">Inactive</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-violet"><i class="bx bxs-star"></i></div><div><div class="ml-stat-value">{{ number_format($stats['popular']) }}</div><div class="ml-stat-label">Popular</div></div></div></div></div></div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form
                    action="{{ route('packages.index') }}"
                    method="GET"
                    class="d-flex flex-wrap align-items-end gap-2">
                    <div><label class="form-label small mb-0">Search</label><input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Package name..." style="min-width:180px;" autocomplete="off"></div>
                    <div><label class="form-label small mb-0">Status</label><select name="is_active" class="form-select form-select-sm" style="min-width:130px;"><option value="">All</option><option value="active" @selected($is_active==='active')>Active</option><option value="inactive" @selected($is_active==='inactive')>Inactive</option></select></div>
                    <div><label class="form-label small mb-0">Popular</label><select name="is_popular" class="form-select form-select-sm" style="min-width:120px;"><option value="">All</option><option value="1" @selected($is_popular==='1')>Yes</option><option value="0" @selected($is_popular==='0')>No</option></select></div>
                    <div><label class="form-label small mb-0">Quota</label><select name="quota_type" class="form-select form-select-sm" style="min-width:140px;"><option value="">All</option><option value="limited" @selected($quota_type==='limited')>Limited</option><option value="unlimited" @selected($quota_type==='unlimited')>Unlimited</option></select></div>
                    <div class="d-flex gap-1"><button type="submit" class="btn btn-sm btn-success"><i class="bi bi-funnel"></i> Filter</button><a href="{{ route('packages.index') }}" class="btn btn-sm btn-light">Reset</a></div>
                </form>
                @can('package.store')
                <a href="{{ route('packages.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add Package</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0">Packages</h6>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($stats['total']) }} packages</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th><th>Package</th><th>Options</th><th class="hide-xs">Features</th><th class="hide-sm">Popular</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold d-block" style="font-size:0.9rem;">{{ \Illuminate\Support\Str::limit($package->name, 40) }}</span>
                                @if ($package->description)
                                <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($package->description, 60) }}</small>
                                @endif
                            </td>
                            <td>
                                @forelse ($package->options as $option)
                                <div class="mb-2 pb-2 border-bottom">
                                    <div class="fw-semibold">{{ $option->name }}</div>
                                    <div class="small text-muted mt-1">
                                        @if ($option->discount_price !== null && $option->discount_price < $option->price)
                                        <span class="text-decoration-line-through">Rp {{ number_format($option->price, 0, ',', '.') }}</span>
                                        <span class="fw-bold text-success ms-1">Rp {{ number_format($option->discount_price, 0, ',', '.') }}</span>
                                        @else
                                        <span class="fw-bold">Rp {{ number_format($option->price, 0, ',', '.') }}</span>
                                        @endif
                                        <span class="mx-1">·</span>
                                        {{ $option->quota }}x Class
                                        <span class="mx-1">·</span>
                                        {{ $option->duration }} {{ ucfirst($option->duration_unit) }}
                                    </div>
                                </div>
                                @empty
                                <span class="text-muted">No options</span>
                                @endforelse
                            </td>
                            <td class="hide-xs">
                                @forelse ($package->features as $feature)
                                <span class="badge bg-light text-dark mb-1">{{ $feature->feature }}</span>
                                @empty
                                <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td class="hide-sm">
                                @if ($package->is_popular)
                                <span class="badge bg-warning"><i class="bi bi-star-fill me-1"></i>Popular</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($package->is_active === 'active')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('package.update')
                                    <a href="{{ route('packages.edit', $package->uuid) }}" title="Edit" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                                    @endcan
                                    @can('package.destroy')
                                    <a onclick="showSweetAlert('{{ $package->uuid }}')" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                    <form id="deleteForm_{{ $package->uuid }}" action="{{ route('packages.destroy', $package->uuid) }}" method="POST" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No packages found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<script>
    function showSweetAlert(getId) {
        Swal.fire({
            title: 'Confirm Deletion',
            text: 'This data will be permanently deleted and cannot be recovered. Are you sure you want to delete it?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Deleted!'
        }).then((result) => {

            if (result.isConfirmed) {
                document
                    .getElementById('deleteForm_' + getId)
                    .submit();

            }

        });
    }
</script>

@endsection

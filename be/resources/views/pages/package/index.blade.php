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

<div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
    <div class="d-flex">
        <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>

        <div class="text-white mt-0">
            <strong>Membership Package Management</strong> <br>
            Manage membership plans, pricing, class quotas, validity periods, and benefits available to your members.
        </div>
    </div>
</div>

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

    <div class="card">

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                @can('package.store')
                {{-- Filter --}}
                <form
                    action="{{ route('packages.index') }}"
                    method="GET"
                    class="row g-2 align-items-center">

                    {{-- Status --}}
                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">

                            <span class="input-group-text">
                                Status
                            </span>

                            <select name="is_active" class="form-select">
                                <option value="">-- All Status --</option>

                                <option
                                    value="active"
                                    {{ request('is_active') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    {{ request('is_active') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                        </div>
                    </div>

                    {{-- Popular --}}
                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">

                            <span class="input-group-text">
                                Most Popular
                            </span>

                            <select name="is_popular" class="form-select">
                                <option value="">-- All --</option>

                                <option
                                    value="1"
                                    {{ request('is_popular') === '1' ? 'selected' : '' }}>
                                    Yes
                                </option>

                                <option
                                    value="0"
                                    {{ request('is_popular') === '0' ? 'selected' : '' }}>
                                    No
                                </option>
                            </select>

                        </div>
                    </div>

                    {{-- Quota --}}
                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">

                            <span class="input-group-text">
                                Quota
                            </span>

                            <select name="quota_type" class="form-select">
                                <option value="">-- All --</option>

                                <option
                                    value="limited"
                                    {{ request('quota_type') === 'limited' ? 'selected' : '' }}>
                                    Limited Quota
                                </option>

                                <option
                                    value="unlimited"
                                    {{ request('quota_type') === 'unlimited' ? 'selected' : '' }}>
                                    Unlimited
                                </option>
                            </select>

                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="col-md-auto col-12">

                        <button
                            class="btn btn-sm btn-success"
                            type="submit">
                            <i class="bi bi-funnel"></i>
                            Filter
                        </button>

                        <a
                            href="{{ route('packages.index') }}"
                            class="btn btn-sm btn-secondary">
                            Reset
                        </a>

                    </div>

                </form>
                @endcan

                {{-- Action --}}
                <div class="d-flex gap-2">

                    @can('package.store')
                    <a
                        href="{{ route('packages.create') }}"
                        class="btn btn-primary btn-md">
                        <i class="bi bi-plus-lg"></i>
                        Add Package
                    </a>
                    @endcan

                </div>

            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive text-nowrap mx-2">

                <table class="table table-bordered" id="table1">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Package</th>
                            <th>Options</th>
                            <th>Features</th>
                            <th>Popular</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($packages as $package)

                        <tr>

                            {{-- No --}}
                            <td>{{ $loop->iteration }}</td>

                            {{-- Package --}}
                            <td>
                                <strong>{{ $package->name }}</strong>

                                @if ($package->description)
                                <br>
                                <small class="text-muted">
                                    {{ $package->description }}
                                </small>
                                @endif
                            </td>

                            {{-- Options --}}
                            <td>

                                @forelse ($package->options as $option)

                                <div class="mb-2 pb-2 border-bottom">

                                    <div class="fw-semibold">
                                        {{ $option->name }}
                                    </div>

                                    <div class="small text-muted mt-1">

                                        {{-- Price --}}
                                        @if ($option->discount_price !== null &&
                                        $option->discount_price < $option->price)

                                            <span class="text-decoration-line-through">
                                                Rp {{ number_format($option->price, 0, ',', '.') }}
                                            </span>

                                            <span class="fw-bold text-success ms-1">
                                                Rp {{ number_format($option->discount_price, 0, ',', '.') }}
                                            </span>

                                            @else

                                            <span class="fw-bold">
                                                Rp {{ number_format($option->price, 0, ',', '.') }}
                                            </span>

                                            @endif

                                            <span class="mx-1">·</span>

                                            {{-- Quota --}}
                                            {{ $option->quota }}x Class

                                            <span class="mx-1">·</span>

                                            {{-- Duration --}}
                                            {{ $option->duration }}
                                            {{ ucfirst($option->duration_unit) }}

                                    </div>

                                </div>

                                @empty

                                <span class="text-muted">
                                    No options
                                </span>

                                @endforelse

                            </td>

                            {{-- Features --}}
                            <td>

                                @forelse ($package->features as $feature)

                                <span class="badge bg-light text-dark mb-1">
                                    {{ $feature->feature }}
                                </span>

                                @empty

                                <span class="text-muted">
                                    -
                                </span>

                                @endforelse

                            </td>

                            {{-- Popular --}}
                            <td>
                                @if ($package->is_popular)

                                <span class="badge bg-warning">
                                    Popular
                                </span>

                                @else

                                <span class="text-muted">
                                    -
                                </span>

                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($package->is_active === 'active')

                                <span class="badge bg-success">
                                    Active
                                </span>

                                @else

                                <span class="badge bg-secondary">
                                    Inactive
                                </span>

                                @endif
                            </td>

                            {{-- Edit --}}
                            <td>

                                @can('package.update')

                                <a href="{{ route('packages.edit', $package->uuid) }}"
                                    class="btn btn-icon btn-success text-white">

                                    <i class="bi bi-pencil-square"></i>
                                    Edit

                                </a>

                                @endcan

                            </td>

                            {{-- Delete --}}
                            <td>

                                @can('package.destroy')

                                <a
                                    onclick="showSweetAlert('{{ $package->uuid }}')"
                                    title="Delete"
                                    class="btn btn-icon btn-danger text-white">

                                    <i class="bi bi-x-square"></i>
                                    Delete

                                </a>

                                <form
                                    id="deleteForm_{{ $package->uuid }}"
                                    action="{{ route('packages.destroy', $package->uuid) }}"
                                    method="POST">

                                    @method('DELETE')
                                    @csrf

                                </form>

                                @endcan

                            </td>

                        </tr>

                        @endforeach

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
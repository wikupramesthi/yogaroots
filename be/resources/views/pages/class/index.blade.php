@extends('layouts.app')

@section('title', 'Classes')

@section('content')

@section('breadcrumb')
<x-breadcrumb
    title="Classes"
    page="Classes"
    active="All Classes"
    route="{{ route('classes.index') }}" />
@endsection

<section class="section">

    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">

        <span class="alert-text text-white">
            {{ session('success') }}
        </span>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">

            <span aria-hidden="true">&times;</span>

        </button>

    </div>
    @endif

    {{-- Alert Error --}}
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">

        <span class="alert-text text-white">
            {{ session('error') }}
        </span>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close">

            <span aria-hidden="true">&times;</span>

        </button>

    </div>
    @endif

    {{-- Statistic cards: numbers follow the active filter --}}
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-primary"><i class="bx bx-dumbbell"></i></div><div><div class="ml-stat-value">{{ number_format($stats['total']) }}</div><div class="ml-stat-label">Total Classes</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-success"><i class="bx bx-check-circle"></i></div><div><div class="ml-stat-value">{{ number_format($stats['active']) }}</div><div class="ml-stat-label">Active</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-warning"><i class="bx bx-pause-circle"></i></div><div><div class="ml-stat-value">{{ number_format($stats['inactive']) }}</div><div class="ml-stat-label">Inactive</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-violet"><i class="bx bx-calendar-event"></i></div><div><div class="ml-stat-value">{{ number_format($stats['schedules']) }}</div><div class="ml-stat-label">Total Schedules</div></div></div></div></div></div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form
                    action="{{ route('classes.index') }}"
                    method="GET"
                    class="d-flex flex-wrap align-items-end gap-2">
                    <div><label class="form-label small mb-0">Search</label><input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Class name..." style="min-width:180px;" autocomplete="off"></div>
                    <div><label class="form-label small mb-0">Level</label><select name="level" class="form-select form-select-sm" style="min-width:150px;"><option value="">All</option><option value="foundation" @selected($level==='foundation')>Foundation</option><option value="intermediate" @selected($level==='intermediate')>Intermediate</option><option value="advance" @selected($level==='advance')>Advance</option></select></div>
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                    <div><label class="form-label small mb-0">Instructor</label><select name="instructor_uuid" class="form-select form-select-sm" style="min-width:160px;"><option value="">All Instructors</option>@foreach($instructors as $instructor)<option value="{{ $instructor->uuid }}" @selected($instructor_uuid==$instructor->uuid)>{{ $instructor->name }}</option>@endforeach</select></div>
                    @endif
                    <div><label class="form-label small mb-0">Status</label><select name="is_active" class="form-select form-select-sm" style="min-width:130px;"><option value="">All</option><option value="active" @selected($is_active==='active')>Active</option><option value="inactive" @selected($is_active==='inactive')>Inactive</option></select></div>
                    <div class="d-flex gap-1"><button type="submit" class="btn btn-sm btn-success"><i class="bi bi-funnel"></i> Filter</button><a href="{{ route('classes.index') }}" class="btn btn-sm btn-light">Reset</a></div>
                </form>
                @can('classes.create')
                <a href="{{ route('classes.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Add Class</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0">Classes</h6>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($stats['total']) }} classes</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th><th>Class</th><th>Level</th><th class="hide-xs">Duration</th><th class="hide-sm">Instructor</th><th>Price</th><th class="hide-xs">Quota</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $class)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if ($class->image)
                                    <img src="{{ asset('storage/' . $class->image) }}" alt="{{ $class->name }}" class="rounded" style="width:48px;height:34px;object-fit:cover;" loading="lazy">
                                    @else
                                    <span class="d-inline-flex align-items-center justify-content-center rounded bg-light text-muted" style="width:48px;height:34px;"><i class="bi bi-image"></i></span>
                                    @endif
                                    <div>
                                        <span class="fw-semibold d-block" style="font-size:0.9rem;">{{ \Illuminate\Support\Str::limit($class->name, 40) }}</span>
                                        @if ($class->description)
                                        <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($class->description, 60) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @switch($class->level)
                                @case('foundation')
                                <span class="badge bg-success" role="button" data-bs-toggle="modal" data-bs-target="#modal-change-level-{{ $class->uuid }}" title="Change level">Foundation</span>
                                @break
                                @case('intermediate')
                                <span class="badge bg-warning text-dark" role="button" data-bs-toggle="modal" data-bs-target="#modal-change-level-{{ $class->uuid }}" title="Change level">Intermediate</span>
                                @break
                                @case('advance')
                                <span class="badge bg-danger" role="button" data-bs-toggle="modal" data-bs-target="#modal-change-level-{{ $class->uuid }}" title="Change level">Advance</span>
                                @break
                                @default
                                <span class="badge bg-secondary" role="button" data-bs-toggle="modal" data-bs-target="#modal-change-level-{{ $class->uuid }}" title="Change level">-</span>
                                @endswitch
                            </td>
                            <td class="hide-xs"><small>{{ $class->duration ? $class->duration . ' min' : '-' }}</small></td>
                            <td class="hide-sm">
                                @if ($class->instructor)
                                <div class="d-flex align-items-center gap-2">
                                    @if ($class->instructor->foto)
                                    <img src="{{ asset('storage/' . $class->instructor->foto) }}" alt="{{ $class->instructor->name }}" class="rounded-circle" style="width:28px;height:28px;object-fit:cover;" loading="lazy">
                                    @endif
                                    <small>{{ $class->instructor->name }}</small>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td><strong>Rp {{ number_format($class->price, 0, ',', '.') }}</strong></td>
                            <td class="hide-xs"><span class="badge bg-secondary">{{ $class->quota_cost }}x</span></td>
                            <td>
                                @if ($class->is_active === 'active')
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('classes.update')
                                    <a href="{{ route('classes.edit', $class->uuid) }}" title="Edit" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                                    @endcan
                                    @can('classes.destroy')
                                    <a onclick="showSweetAlert('{{ $class->uuid }}')" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                    <form id="deleteForm_{{ $class->uuid }}" action="{{ route('classes.destroy', $class->uuid) }}" method="POST" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted">No classes found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

@include('pages.class.modal-change-level')

<script>
    function showSweetAlert(getId) {

        Swal.fire({

            title: 'Delete Class?',
            text: 'This class will be permanently deleted. Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'

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

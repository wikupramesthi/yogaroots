@extends('layouts.app')
@section('title', 'Instructors')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Instructors" page="Instructors" active="All instructors" route="{{ route('instruktur.index') }}" />
@endsection

<section class="section">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    {{-- Statistic cards: numbers follow the active filter --}}
    <div class="row mb-4 g-3 ml-stats">
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-primary"><i class="bx bx-user-voice"></i></div><div><div class="ml-stat-value">{{ number_format($stats['total']) }}</div><div class="ml-stat-label">Total Instructors</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-info"><i class="bx bx-male"></i></div><div><div class="ml-stat-value">{{ number_format($stats['male']) }}</div><div class="ml-stat-label">Male</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-violet"><i class="bx bx-female"></i></div><div><div class="ml-stat-value">{{ number_format($stats['female']) }}</div><div class="ml-stat-label">Female</div></div></div></div></div></div>
        <div class="col-6 col-md-4 col-xl"><div class="card shadow-sm h-100"><div class="card-body py-2 px-3"><div class="ml-stat"><div class="ml-stat-icon ic-success"><i class="bx bx-user-plus"></i></div><div><div class="ml-stat-value">{{ number_format($stats['new_month']) }}</div><div class="ml-stat-label">New This Month</div></div></div></div></div></div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-2 px-3">
            <div class="d-flex flex-wrap align-items-end justify-content-between gap-3">
                <form method="GET" action="{{ route('instruktur.index') }}" class="d-flex flex-wrap align-items-end gap-2">
                    <div><label class="form-label small mb-0">Search</label><input type="text" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Name, email..." style="min-width:180px;" autocomplete="off"></div>
                    <div><label class="form-label small mb-0">Gender</label><select name="jenis_kelamin" class="form-select form-select-sm" style="min-width:130px;"><option value="">All</option><option value="L" @selected($jenisKelamin==='L')>Male</option><option value="P" @selected($jenisKelamin==='P')>Female</option></select></div>
                    <div><label class="form-label small mb-0">Specialization</label>
                        <select name="specialization" class="form-select form-select-sm" style="min-width:160px;">
                            <option value="">All</option>
                            @foreach ($specializations as $specialization)
                            <option value="{{ $specialization->uuid }}" @selected($specializationUuid===$specialization->uuid)>{{ $specialization->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label class="form-label small mb-0">Joined from</label><input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}"></div>
                    <div><label class="form-label small mb-0">Joined until</label><input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}"></div>
                    <div class="d-flex gap-1"><button type="submit" class="btn btn-sm btn-success"><i class="bi bi-funnel"></i> Filter</button><a href="{{ route('instruktur.index') }}" class="btn btn-sm btn-light">Reset</a></div>
                </form>
                <div class="d-flex gap-2">
                    @can('instruktur.store')
                    <a href="{{ route('instruktur.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Instructor
                    </a>
                    <form action="{{ route('instruktur.restore') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to restore all deleted instructors?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-warning text-white">
                            <i class="bi bi-arrow-counterclockwise"></i> Restore Data
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0">Instructors</h6>
                <span class="badge bg-primary-subtle text-primary">{{ number_format($stats['total']) }} instructors</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th><th>Photo</th><th>Full Name</th><th>Specialization</th><th>Gender</th><th class="hide-sm">Email</th><th>Experience</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" style="width:42px;height:42px;object-fit:cover;" loading="lazy">
                                @else
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-muted" style="width:42px;height:42px;"><i class="bi bi-person"></i></span>
                                @endif
                            </td>
                            <td><span class="fw-semibold d-block" style="font-size:0.9rem;">{{ $user->name }}</span></td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse ($user->specializations as $specialization)
                                    <span class="badge bg-primary-subtle text-primary">{{ $specialization->name }}</span>
                                    @empty
                                    <span class="text-muted">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                @if ($user->jenis_kelamin === 'L')
                                <span class="badge bg-info">Male</span>
                                @elseif ($user->jenis_kelamin === 'P')
                                <span class="badge bg-secondary">Female</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="hide-sm"><small>{{ $user->email }}</small></td>
                            <td><small>{{ $user->pengalaman ?? '-' }}</small></td>
                            <td>
                                <div class="d-flex gap-1">
                                    @can('instruktur.update')
                                    <a data-bs-toggle="modal" data-bs-target="#modal-form-view-instruktur-{{ $user->uuid }}" title="Detail" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a>
                                    @include('pages.instruktur.modal-view')
                                    <a href="{{ route('instruktur.edit', $user->uuid) }}" title="Edit" class="btn btn-sm btn-success"><i class="bi bi-pencil"></i></a>
                                    @endcan
                                    @can('instruktur.destroy')
                                    <a onclick="showSweetAlert('{{ $user->uuid }}')" title="Delete" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                                    <form id="deleteForm_{{ $user->uuid }}" action="{{ route('instruktur.destroy', $user->uuid) }}" method="POST" class="d-none">
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">No instructors found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- / Content -->

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
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>
@endsection

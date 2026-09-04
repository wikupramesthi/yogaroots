@extends('layouts.app')
@section('title', 'Instructors')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="instructors" page="Instructors" active="All instructors" route="{{ route('instruktur.index') }}" />
@endsection

<!-- Content -->

<div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
    <div class="d-flex">
        <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
        <div class="text-white mt-2">
            <strong>Instructor Data Management</strong>
            <br>
            On this page, you can view, manage, and update instructor data.
        </div>
    </div>
</div>

<section class="section mt-2">
    <div class="card">
        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('instruktur.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Join on</span>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Until</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Gender</span>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Select Gender --</option>
                                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Specializations</span>

                            <select name="specialization" class="form-select">
                                <option value="">-- All Specializations --</option>

                                @foreach ($specializations as $specialization)
                                <option
                                    value="{{ $specialization->uuid }}"
                                    {{ request('specialization') == $specialization->uuid ? 'selected' : '' }}>
                                    {{ $specialization->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('instruktur.index') }}" class="btn btn-sm btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="d-flex gap-2">
                    @can('instruktur.store')
                    <a href="{{ route('instruktur.create') }}" class="btn btn-primary btn-md">
                        <i class="bi bi-plus-lg"></i> Add Instructor
                    </a>
                    @endcan

                    @can('instruktur.store')
                    <form action="{{ route('instruktur.restore') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to restore all deleted instructors?')">
                        @csrf
                        <button type="submit" class="btn btn-warning text-white btn-md">
                            <i class="bi bi-arrow-counterclockwise"></i> Restore Data
                        </button>
                    </form>
                    @endcan
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table-hover align-middle text-wrap text-break" id="table1">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Photo</th>
                            <th>Full Name</th>
                            <th>Specialization</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Experience</th>
                            <th>Details</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                    alt="Foto {{ $user->name }}" width="60" class="img-thumbnail">
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse ($user->specializations as $specialization)
                                    <span class="badge bg-primary">
                                        {{ $specialization->name }}
                                    </span>
                                    @empty
                                    <span class="text-muted">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp ?? '-' }}</td>
                            <td>{{ $user->pengalaman }}</td>
                            <td>
                                @can('instruktur.update')
                                <a data-bs-toggle="modal" data-bs-target="#modal-form-view-faq-{{ $user->uuid }}"
                                    class="btn btn-icon btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @include('pages.instruktur.modal-view')
                                @endcan
                            </td>
                            <td>
                                @can('instruktur.update')
                                <a href="{{ route('instruktur.edit', $user->uuid) }}" title="Edit"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endcan
                            </td>

                            <td>
                                @can('instruktur.destroy')
                                <a onclick="showSweetAlert('{{ $user->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i>
                                </a>
                                <form id="deleteForm_{{ $user->uuid }}"
                                    action="{{ route('instruktur.destroy', $user->uuid) }}" method="POST">
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
                // If the user clicks "Yes, delete it!", submit the corresponding form
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>

@endsection
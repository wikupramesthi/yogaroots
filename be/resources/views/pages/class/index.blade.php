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

    <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                {{-- Filter --}}
                <form
                    action="{{ route('classes.index') }}"
                    method="GET"
                    class="row g-2 align-items-center">

                    {{-- Level --}}
                    <div class="col-md-auto col-12">

                        <div class="input-group input-group-sm">

                            <span class="input-group-text">
                                Level
                            </span>

                            <select name="level" class="form-select">

                                <option value="">
                                    -- All --
                                </option>

                                <option
                                    value="pemula"
                                    {{ request('level') == 'pemula' ? 'selected' : '' }}>
                                    Pemula
                                </option>

                                <option
                                    value="menengah"
                                    {{ request('level') == 'menengah' ? 'selected' : '' }}>
                                    Menengah
                                </option>

                                <option
                                    value="advance"
                                    {{ request('level') == 'advance' ? 'selected' : '' }}>
                                    Advance
                                </option>

                                <option
                                    value="semua_level"
                                    {{ request('level') == 'semua_level' ? 'selected' : '' }}>
                                    Semua Level
                                </option>

                            </select>

                        </div>

                    </div>

                    {{-- Instructor --}}
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('superadmin'))
                    {{-- Instructor Filter --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-600">
                            Instructor
                        </label>

                        <select
                            name="instructor_uuid"
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-gray-900 focus:ring-gray-900">
                            <option value="">All Instructors</option>

                            @foreach($instructors as $instructor)
                            <option
                                value="{{ $instructor->uuid }}"
                                {{ request('instructor_uuid') == $instructor->uuid ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- Status --}}
                    <div class="col-md-auto col-12">

                        <div class="input-group input-group-sm">

                            <span class="input-group-text">
                                Status
                            </span>

                            <select
                                name="is_active"
                                class="form-select">

                                <option value="">
                                    -- All --
                                </option>

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

                    {{-- Filter Button --}}
                    <div class="col-md-auto col-12">

                        <button
                            class="btn btn-sm btn-success"
                            type="submit">

                            <i class="bi bi-funnel"></i>
                            Filter

                        </button>

                        <a
                            href="{{ route('classes.index') }}"
                            class="btn btn-sm btn-secondary">

                            Reset

                        </a>

                    </div>

                </form>

                {{-- Add Class --}}
                <div class="d-flex gap-2">

                    @can('classes.store')

                    <button
                        type="button"
                        class="btn btn-primary btn-md"
                        data-bs-toggle="modal"
                        data-bs-target="#modal-form-add-class">

                        <i class="bi bi-plus-lg"></i>
                        Add Class

                    </button>

                    @endcan

                </div>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive text-nowrap mx-2">

                <table
                    class="table table-bordered"
                    id="table1">

                    <thead>

                        <tr>

                            <th>No.</th>
                            <th>Class</th>
                            <th>Level</th>
                            <th>Duration</th>
                            <th>Instructor</th>
                            <th>Price</th>
                            <th>Quota Cost</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($classes as $class)

                        <tr>

                            {{-- No --}}
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            {{-- Class --}}
                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    @if ($class->image)

                                    <img
                                        src="{{ asset('storage/' . $class->image) }}"
                                        alt="{{ $class->name }}"
                                        width="60"
                                        height="60"
                                        class="rounded"
                                        style="object-fit: cover;">

                                    @else

                                    <div
                                        class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width:60px;height:60px;">

                                        <i class="bi bi-image text-muted fs-4"></i>

                                    </div>

                                    @endif

                                    <div>

                                        <strong>
                                            {{ $class->name }}
                                        </strong>

                                        @if ($class->description)

                                        <br>

                                        <small class="text-muted">

                                            {{ \Illuminate\Support\Str::limit($class->description, 80) }}

                                        </small>

                                        @endif

                                    </div>

                                </div>

                            </td>

                            {{-- Level --}}
                            <td>

                                @switch($class->level)

                                @case('pemula')

                                <span class="badge bg-success">
                                    Pemula
                                </span>

                                @break

                                @case('menengah')

                                <span class="badge bg-warning text-dark">
                                    Menengah
                                </span>

                                @break

                                @case('advance')

                                <span class="badge bg-danger">
                                    Advance
                                </span>

                                @break

                                @default

                                <span class="badge bg-primary">
                                    Semua Level
                                </span>

                                @endswitch

                            </td>

                            {{-- Duration --}}
                            <td>

                                @if ($class->duration)

                                {{ $class->duration }} min

                                @else

                                -

                                @endif

                            </td>

                            {{-- Instructor --}}
                            <td>

                                @if ($class->instructor)

                                <div class="d-flex align-items-center gap-2">

                                    @if ($class->instructor->foto)

                                    <img
                                        src="{{ asset('storage/' . $class->instructor->foto) }}"
                                        alt="{{ $class->instructor->name }}"
                                        width="35"
                                        height="35"
                                        class="rounded-circle"
                                        style="object-fit: cover;">

                                    @endif

                                    <span>
                                        {{ $class->instructor->name }}
                                    </span>

                                </div>

                                @else

                                <span class="text-muted">
                                    -
                                </span>

                                @endif

                            </td>

                            {{-- Price --}}
                            <td>

                                <strong>
                                    Rp {{ number_format($class->price, 0, ',', '.') }}
                                </strong>

                            </td>

                            {{-- Quota Cost --}}
                            <td>

                                <span class="badge bg-secondary">
                                    {{ $class->quota_cost }}x
                                </span>

                            </td>

                            {{-- Status --}}
                            <td>

                                @if ($class->is_active === 'active')

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

                                @can('classes.update')

                                <a
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-form-edit-class-{{ $class->uuid }}"
                                    class="btn btn-icon btn-success text-white">

                                    <i class="bi bi-pencil-square"></i>
                                    Edit

                                </a>

                                @include('pages.class.modal-edit')

                                @endcan

                            </td>

                            {{-- Delete --}}
                            <td>

                                @can('classes.destroy')

                                <a
                                    onclick="showSweetAlert('{{ $class->uuid }}')"
                                    title="Delete"
                                    class="btn btn-icon btn-danger text-white">

                                    <i class="bi bi-x-square"></i>
                                    Delete

                                </a>

                                <form
                                    id="deleteForm_{{ $class->uuid }}"
                                    action="{{ route('classes.destroy', $class->uuid) }}"
                                    method="POST">

                                    @method('DELETE')
                                    @csrf

                                </form>

                                @endcan

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td
                                colspan="10"
                                class="text-center py-4">

                                <div class="text-muted">

                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                    No classes found.

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

{{-- Modal Create --}}
@include('pages.class.modal-create')

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
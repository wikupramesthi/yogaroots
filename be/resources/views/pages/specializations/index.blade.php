@extends('layouts.app')
@section('title', 'Instructors')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Instructors" page="Instructors" active="Yoga Specialization" route="{{ route('specializations.index') }}" />
@endsection
<!-- Content -->
<section class="section">

    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
        <div class="d-flex">
            <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
            <div class="text-white mt-2">
                Manage the Specializations available in the system.<br>
                Add, update, or deactivate specializations to support instructor and class management.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Yoga Specialization</h4>
                @can('specializations.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-specializations">
                    <i class="bi bi-plus-lg"></i>
                    Add New
                </button>
                @endcan

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Yoga Specialization</th>
                            <th>Description</th>
                            <th>Total Classes</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($specializations as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->specializations_count }}</td>

                            <td>
                                @can('specializations.update')
                                <a data-bs-toggle="modal"
                                    data-bs-target="#modal-form-edit-specializations-{{ $item->uuid }}"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @include('pages.specializations.modal-edit')
                                @endcan
                            </td>

                            <td>
                                @can('specializations.destroy')
                                <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i> Hapus
                                </a>
                                <form id="deleteForm_{{ $item->uuid }}"
                                    action="{{ route('specializations.destroy', $item->uuid) }}" method="POST">
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
<!-- / Content -->

<!--/ Basic Bootstrap Table -->
@include('pages.specializations.modal-create')

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
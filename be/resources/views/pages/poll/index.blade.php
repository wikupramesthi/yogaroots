@extends('layouts.app')
@section('title', 'Public Poll')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Information Center" page="Information Center" active="Public Poll" route="{{ route('poll.index') }}" />
@endsection
<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Public Poll</h4>
                @can('poll.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-polls">
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
                            <th>Question</th>
                            <th>Options</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($polls as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->question }}</td>
                            <td>
                                @foreach($item->options as $option)
                                <span class="badge bg-primary">{{ $option }}</span>
                                @endforeach
                            </td>
                            <td>{{ $item->status }}</td>
                            <td>
                                @can('poll.update')
                                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-polls-{{  $item->uuid }}"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @include('pages.poll.modal-edit')
                                @endcan
                            </td>

                            <td>
                                @can('poll.destroy')
                                <a onclick="showSweetAlert('{{  $item->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i> Delete
                                </a>
                                <form id="deleteForm_{{  $item->uuid }}" action="{{ route('poll.destroy',  $item->uuid) }}"
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
<!-- / Content -->

<!--/ Basic Bootstrap Table -->
@include('pages.poll.modal-create')

<script>
    function showSweetAlert(getId) {
        Swal.fire({
            title: 'Delete Confirmation',
            text: 'This data will be permanently deleted and cannot be recovered. Are you sure you want to delete it?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "Yes, delete it!", submit the corresponding form
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>


<script>
document.getElementById('add-option').addEventListener('click', function() {
    let wrapper = document.getElementById('options-wrapper');
    let input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.classList.add('form-control', 'mb-2');
    input.placeholder = 'Additional option';
    wrapper.appendChild(input);
});
</script>

@endsection
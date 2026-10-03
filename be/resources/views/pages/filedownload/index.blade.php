@extends('layouts.app')
@section('title', 'School Documents')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="School Documents" page="School Documents" active="Document List" route="{{ route('filedownload.index') }}" />
@endsection
<!-- Content -->
<section class="section">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">School Documents</h4>
                @can('filedownload.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-dokumen">
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
                            <th style="width: 20px;">No.</th>
                            <th class="text-wrap" style="width: 250px;">Title</th>
                            <th class="text-wrap" style="width: 350px;">Description</th>
                            <th>Category</th>
                            <th>View File</th>
                            @role(['super-admin', 'admin'])
                            <th>Edit</th>
                            <th>Delete</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($downloads as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-wrap" style="width: 200px;">{{ $item->judul }}</td>
                            <td class="text-wrap" style="width: 300px;">{{ $item->deskripsi }}</td>
                            <td>
                                @switch($item->kategori)
                                @case('akademik')
                                Curriculum Document
                                @break
                                @case('informasi')
                                Public Information
                                @break
                                @case('laporan')
                                Report
                                @break
                                @case('edaran')
                                Circular Letter
                                @break
                                @default
                                <span class="text-muted">Unknown</span>
                                @endswitch
                            </td>

                            <td>
                                @if($item->file)
                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn=icon btn-primary">
                                    <i class="bi bi-file-earmark-pdf"></i> View File
                                </a>
                                @else
                                <span class="text-muted">No file yet</span>
                                @endif
                            </td>

                            @role(['super-admin', 'admin'])

                            <td>
                                @can('filedownload.update')
                                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-dokumen-{{ $item->id }}"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @include('pages.filedownload.modal-edit')
                                @endcan
                            </td>

                            <td>
                                @can('filedownload.destroy')
                                <a onclick="showSweetAlert('{{ $item->id }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i>
                                </a>
                                <form id="deleteForm_{{ $item->id }}" action="{{ route('filedownload.destroy', $item->id) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                </form>
                                @endcan
                            </td>

                            @endrole


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- / Content -->

@include('pages.filedownload.modal-create')

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
@endsection
@extends('layouts.app')
@section('title', 'Static Pages')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Master Data" page="Master Data" active="Static Pages" route="{{ route('pages.index') }}" />
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

    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
        <div class="d-flex">
            <i class="bi-exclamation-triangle-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
            <div class="text-white mt-2">
                <strong>Attention!</strong> Changing the <em>sidebar</em> status will affect the appearance and layout of the page.
                <br>
                Please make sure to review the changes before saving.
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">All Pages</h4>
                @can('pages.store')
                <a href="{{ route('pages.create') }}" class="btn btn-primary btn-md"><i class="bi bi-plus-lg"></i>
                    Add New Page</a>
                @endcan

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Sidebar</th>
                            <th>Status</th>
                            <th>Publish Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($pages as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="/storage/{{ $item->featured_image }}" class="img-fluid"
                                    style="max-height:80px" alt="{{ $item->title }}">
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>
                                @php
                                $statusClass = $item->has_sidebar ? 'btn-info' : 'btn-danger';
                                $statusText = $item->has_sidebar ? 'Ya' : 'Tidak';
                                @endphp

                                <button type="button" class="btn {{ $statusClass }} btn-sm text-white"
                                    data-bs-toggle="modal" data-bs-target="#modalUpdateSidebar-{{ $item->uuid }}">
                                    {{ $statusText }}
                                </button>

                                @include('pages.halaman.modal-update-sidebar')
                            </td>
                            <td>
                                {{ $item->is_published ? 'Aktif' : 'Tidak Aktif' }}
                            </td>
                            <td> {{ $item->created_at->format('d-m-Y') }}</td>

                            <td>
                                @can('pages.update')
                                <a href="{{ route('pages.edit', $item->uuid) }}"
                                    class="btn btn-icon btn-success text-white"><i class="bi bi-pencil-square"></i>
                                    Edit</a>
                                @endcan
                            </td>

                            <td>
                                @can('pages.destroy')
                                <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i> Hapus
                                </a>
                                <form id="deleteForm_{{ $item->uuid }}"
                                    action="{{ route('pages.destroy', $item->uuid) }}" method="POST">
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
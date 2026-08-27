@extends('layouts.app')
@section('title', 'Semua Kategori')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Kategori" page="Kategori" active="Semua Kategori" route="{{ route('categories.index') }}" />
@endsection
<!-- Content -->
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Semua Kategori</h4>
                @can('categories.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-categories">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Baru
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
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th>Total Publikasi</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug  }}</td>
                            <td>{{ $item->articles_count  }}</td>
                            <td>
                                @can('categories.update')
                                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-categories-{{  $item->uuid }}"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @include('pages.categories.modal-edit')
                                @endcan
                            </td>

                            <td>
                                @can('categories.destroy')
                                <a onclick="showSweetAlert('{{  $item->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i> Hapus
                                </a>
                                <form id="deleteForm_{{  $item->uuid }}" action="{{ route('categories.destroy',  $item->uuid) }}"
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
@include('pages.categories.modal-create')

<script>
    function showSweetAlert(getId) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Data ini akan dihapus secara permanen dan tidak bisa dikembalikan. Apakah Anda yakin ingin menghapusnya?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "Yes, delete it!", submit the corresponding form
                document.getElementById('deleteForm_' + getId).submit();
            }
        });
    }
</script>
@endsection
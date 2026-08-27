@extends('layouts.app')
@section('title', 'Media Pustaka')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Media Pustaka" page="Media Pustaka" active="Banner & Slider" route="{{ route('banner.index') }}" />
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
                <h4 class="fw-normal mb-0 text-body">Banner & Slider</h4>
                @can('banner.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-banner">
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
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Posisi</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $item->gambar() }}" class="img-fluid" style="max-height:80px"
                                    alt="">
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->posisi }}</td>
                            <td>{{ $item->link }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                @can('banner.update')
                                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-banner-{{ $item->uuid }}"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @include('pages.banner.modal-edit')
                                @endcan
                            </td>

                            <td>
                                @can('banner.destroy')
                                <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i> Hapus
                                </a>
                                <form id="deleteForm_{{ $item->uuid }}" action="{{ route('banner.destroy', $item->uuid) }}"
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

@include('pages.banner.modal-create')

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
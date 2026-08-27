@extends('layouts.app')
@section('title', 'Semua Kategori')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Disabilitas" page="Disabilitas" active="Semua Kategori" route="{{ route('disabilities.index') }}" />
@endsection
<!-- Content -->
<section class="section">

    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
    <div class="d-flex">
        <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
        <div class="text-white mt-2">
            Kelola <strong>Kategori Disabilitas</strong> di sistem.<br>
            Tambahkan, perbarui, atau hapus kategori sesuai kebutuhan, dan pantau jumlah program yang terkait dengan setiap kategori.
        </div>
    </div>
</div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Semua Kategori</h4>
                @can('disabilities.store')
                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                        data-bs-target="#modal-form-add-disabilities">
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
                            <th>Kategori Disabilitas</th>
                            <th>Slug</th>
                            <th>Total Siswa</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disabilities as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>{{ $item->disabilities_count }}</td>

                                <td>
                                    @can('disabilities.update')
                                        <a data-bs-toggle="modal"
                                            data-bs-target="#modal-form-edit-disabilities-{{ $item->uuid }}"
                                            class="btn btn-icon btn-success text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @include('pages.disabilities.modal-edit')
                                    @endcan
                                </td>

                                <td>
                                    @can('disabilities.destroy')
                                        <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                            class="btn btn-icon btn-danger text-white">
                                            <i class="bi bi-x-square"></i> Hapus
                                        </a>
                                        <form id="deleteForm_{{ $item->uuid }}"
                                            action="{{ route('disabilities.destroy', $item->uuid) }}" method="POST">
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
@include('pages.disabilities.modal-create')

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

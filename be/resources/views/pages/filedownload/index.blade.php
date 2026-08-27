@extends('layouts.app')
@section('title', 'Dokumen Sekolah')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Dokumen Sekolah" page="Dokumen Sekolah" active="Daftar Dokumen" route="{{ route('filedownload.index') }}" />
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
                <h4 class="fw-normal mb-0 text-body">Dokumen Sekolah</h4>
                @can('filedownload.store')
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-dokumen">
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
                            <th style="width: 20px;">No.</th>
                            <th class="text-wrap" style="width: 250px;">Judul</th>
                            <th class="text-wrap" style="width: 350px;">Deskripsi</th>
                            <th>Kategori</th>
                            <th>Lihat File</th>
                            @role(['super-admin', 'admin'])
                            <th>Edit</th>
                            <th>Hapus</th>
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
                                Dokumen Kurikulum
                                @break
                                @case('informasi')
                                Informasi Publik
                                @break
                                @case('laporan')
                                Laporan
                                @break
                                @case('edaran')
                                Surat Edaran
                                @break
                                @default
                                <span class="text-muted">Tidak Diketahui</span>
                                @endswitch
                            </td>

                            <td>
                                @if($item->file)
                                <a href="{{ asset('storage/' . $item->file) }}" target="_blank" class="btn btn=icon btn-primary">
                                    <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                </a>
                                @else
                                <span class="text-muted">Belum ada file</span>
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
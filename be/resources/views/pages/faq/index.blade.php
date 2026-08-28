@extends('layouts.app')
@section('title', 'Pusat Informasi')
@section('content')

@section('breadcrumb')
<x-breadcrumb title="Pusat Informasi" page="Pusat Informasi" active="Faq & Answer" route="{{ route('faq.index') }}" />
@endsection
<!-- Content -->
<section class="section">

    <div class="alert alert-info alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
        <div class="d-flex">
            <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
            <div class="text-white mt-2">
                Lihat informasi dan jawaban seputar <strong>FAQ Sekolah Luar Biasa Negeri Kota Bekasi</strong>.<br>
                Panduan ini membantu orang tua, siswa, dan masyarakat memahami layanan serta program pendidikan
                inklusif.
            </div>

        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible mb-3 mt-3 fade show" role="alert">
        <span class="alert-text text-white"> {{ session('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Faq & Answer</h4>
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                    data-bs-target="#modal-form-add-faq">
                    <i class="bi bi-plus-lg"></i> Tambah Baru
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table table-bordered" id="table1">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanya</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pertanyaan }}</td>
                            <td>{{ $item->urutan }}</td>
                            <td>
                                <span class="badge {{ $item->status === 'active' ? 'bg-info' : 'bg-danger' }}">
                                    {{ $item->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                @can('faq.update')
                                <a data-bs-toggle="modal"
                                    data-bs-target="#modal-form-view-faq-{{ $item->uuid }}"
                                    class="btn btn-icon btn-primary text-white">
                                    Detail
                                </a>
                                @include('pages.faq.modal-view')
                                @endcan
                            </td>

                            <td>
                                @can('faq.update')
                                <a data-bs-toggle="modal" data-bs-target="#modal-form-edit-faq-{{ $item->uuid }}"
                                    class="btn btn-icon btn-success text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @include('pages.faq.modal-edit')
                                @endcan
                            </td>

                            <td>
                                @can('faq.destroy')
                                <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                    class="btn btn-icon btn-danger text-white">
                                    <i class="bi bi-x-square"></i> Hapus
                                </a>
                                <form id="deleteForm_{{ $item->uuid }}"
                                    action="{{ route('faq.destroy', $item->uuid) }}" method="POST">
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

@include('pages.faq.modal-create')

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
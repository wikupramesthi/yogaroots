@extends('layouts.app')
@section('title', 'Layanan')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Layanan" page="Layanan" active="Kegiatan Siswa" route="{{ route('services.index') }}" />
@endsection

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

            <div class="col-md-4">
                <form method="GET" action="{{ route('services.index') }}" class="d-flex align-items-center gap-3">
                    <label for="kategori_layanan" class="me-5 font-weight-bold mb-0">Filter:</label>

                    <select name="kategori_layanan" id="kategori_layanan" class="form-control me-2"
                        onchange="this.form.submit()">
                        <option value="">-- Kegiatan Siswa --</option>
                        <option value="ekstrakurikuler"
                            {{ request('kategori_layanan') == 'ekstrakurikuler' ? 'selected' : '' }}>
                            Ekstrakurikuler
                        </option>
                        <option value="kegiatan" {{ request('kategori_layanan') == 'kegiatan' ? 'selected' : '' }}>
                            Kegiatan Sekolah
                        </option>
                        <option value="bimbingan" {{ request('kategori_layanan') == 'bimbingan' ? 'selected' : '' }}>
                            Bimbingan Akademik
                        </option>
                    </select>

                    @if (request('kategori_layanan'))
                        <a href="{{ route('services.index') }}" class="btn btn-danger btn-md">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center ">
                <h4 class="fw-normal mb-0 text-body">Semua Layanan</h4>
                @can('services.store')
                    <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal"
                        data-bs-target="#modal-form-add-service">
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
                            <th>Gambar/Icon</th>
                            <th>Nama Kegiatan</th>
                            <th>Kategori</th>
                            <th>Link</th>
                            <th>color</th>
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
                                    <img src="{{ $item->icon() }}" class="img-fluid" style="max-height:80px"
                                        alt="">
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->kategori_layanan }}</td>
                                <td>{{ $item->link }}</td>
                                <td>{{ $item->status }}</td>
                                @php
                                    $colors = [
                                        'blue' => '#8e56ff',
                                        'orange' => '#d65905',
                                        'green' => '#1ab69d',
                                        'red' => '#ff5b5c',
                                        'yellow' => '#f5c518',
                                        'purple' => '#a64ac9',
                                        'cyan' => '#00bcd4',
                                        'pink' => '#ff4081',
                                        'teal' => '#009688',
                                        'brown' => '#795548',
                                    ];
                                @endphp

                                <td>
                                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                                        <span
                                            style="
                                                width: 14px;
                                                height: 14px;
                                                border-radius: 50%;
                                                background-color: {{ $colors[$item->color] ?? '#6c757d' }};
                                                display: inline-block;
                                            "></span>
                                        <span>{{ ucfirst($item->color) }}</span>
                                    </span>
                                </td>

                                <td>
                                    @can('services.update')
                                        <a data-bs-toggle="modal"
                                            data-bs-target="#modal-form-edit-service-{{ $item->uuid }}"
                                            class="btn btn-icon btn-success text-white">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @include('pages.layanan.modal-edit')
                                    @endcan
                                </td>

                                <td>
                                    @can('services.destroy')
                                        <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                            class="btn btn-icon btn-danger text-white">
                                            <i class="bi bi-x-square"></i> Hapus
                                        </a>
                                        <form id="deleteForm_{{ $item->uuid }}"
                                            action="{{ route('services.destroy', $item->uuid) }}" method="POST">
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

@include('pages.layanan.modal-create')

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

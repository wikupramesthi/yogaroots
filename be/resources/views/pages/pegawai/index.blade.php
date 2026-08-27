@extends('layouts.app')
@section('title', 'Data Pegawai')
@section('content')

@section('breadcrumb')
    <x-breadcrumb title="Data Pegawai" page="Data Pegawai" active="Semua Pegawai" route="{{ route('pegawai.index') }}" />
@endsection

<!-- Content -->

<div class="alert alert-info alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
    <div class="d-flex">
        <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
        <div class="text-white mt-2">
            <strong>Halaman Pegawai Sekolah</strong>
            <br>
            Pada halaman ini Anda dapat melihat dan mengelola data pegawai sekolah.
        </div>
    </div>
</div>

<section class="section mt-2">
    <div class="card">
        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">
                <form action="{{ route('pegawai.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Aktif Kerja</span>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Sampai</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Jenis Kelamin</span>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">Kepegawaian</span>
                            <select name="kepegawaian" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="asn" {{ request('kepegawaian') == 'asn' ? 'selected' : '' }}>ASN
                                </option>
                                <option value="honorer" {{ request('kepegawaian') == 'honorer' ? 'selected' : '' }}>
                                    Honorer</option>
                                <option value="magang" {{ request('kepegawaian') == 'magang' ? 'selected' : '' }}>Magang
                                </option>
                                <option value="lainnya" {{ request('kepegawaian') == 'lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-auto col-12">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="d-flex gap-2">
                    @can('pegawai.store')
                        <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-md">
                            <i class="bi bi-plus-lg"></i> Tambah Pegawai
                        </a>
                    @endcan

                    @can('pegawai.store')
                        <form action="{{ route('pegawai.restore') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin merestore semua pegawai yang terhapus?')">
                            @csrf
                            <button type="submit" class="btn btn-warning text-white btn-md">
                                <i class="bi bi-arrow-counterclockwise"></i> Restore Semua
                            </button>
                        </form>
                    @endcan
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap mx-2">
                <table class="table table-hover align-middle text-wrap text-break" id="table1">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Foto</th>
                            <th>Nama Lengkap</th>
                            <th>NIP/NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat, Tgl Lahir</th>
                            <th>Email</th>
                            <th>No. Handphone</th>
                            <th>Jabatan</th>
                            <th>Status Kepegawaian</th>
                            <th>Detail</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                            alt="Foto {{ $user->name }}" width="60" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>
                                    {{ $user->tempat_lahir }},
                                    {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->no_hp ?? '-' }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>{{ ucfirst($user->kepegawaian) ?? '-' }}</td>
                                <td>
                                    @can('pegawai.update')
                                        <a data-bs-toggle="modal" data-bs-target="#modal-form-view-faq-{{ $user->uuid }}"
                                            class="btn btn-icon btn-info text-white">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @include('pages.pegawai.modal-view')
                                    @endcan
                                </td>
                                <td>
                                    @can('pegawai.update')
                                        <a href="{{ route('pegawai.edit', $user->uuid) }}" title="Edit"
                                            class="btn btn-icon btn-success text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan
                                </td>

                                <td>
                                    @can('pegawai.destroy')
                                        <a onclick="showSweetAlert('{{ $user->uuid }}')" title="Delete"
                                            class="btn btn-icon btn-danger text-white">
                                            <i class="bi bi-x-square"></i>
                                        </a>
                                        <form id="deleteForm_{{ $user->uuid }}"
                                            action="{{ route('pegawai.destroy', $user->uuid) }}" method="POST">
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

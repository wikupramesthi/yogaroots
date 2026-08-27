@extends('layouts.app')
@section('title', 'Daftar Calon Murid')
@section('content')

    <section class="section">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show" role="alert">
                <span class="alert-text text-white"> {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @role('admin|super-admin')
            <div class="alert alert-info alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
                <div class="d-flex">
                    <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
                    <div class="text-white">
                        Halaman ini digunakan oleh <strong>admin</strong> untuk memverifikasi dan mengelola data pendaftaran
                        siswa
                        SLB Patriot Kota Bekasi Tahun Pelajaran {{ date('Y') }} / {{ date('Y') + 1 }}.
                        <br>
                        Status pendaftaran yang dapat ditetapkan meliputi:
                        <span class="badge bg-light text-dark me-1">Seleksi</span>
                        <span class="badge bg-light text-dark me-1">Hadir</span>
                        <span class="badge bg-light text-dark me-1">Reschedule</span>
                        <span class="badge bg-light text-dark me-1">Diterima</span>
                        <span class="badge bg-light text-dark me-1">Tidak Diterima</span>
                    </div>
                </div>
            </div>
        @endrole

        @if (!empty($showFinalProgramAlert) && $showFinalProgramAlert)
            <div class="alert alert-success alert-dismissible mb-3 mt-3 fade show position-relative" role="alert">
                <div class="d-flex">
                    <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
                    @foreach ($programs as $item)
                        <div class="text-white mt-2">
                            <strong>Terima kasih!</strong> Anda telah berhasil melengkapi seluruh data calon murid dengan baik.
                            <br>
                            Data Anda siap untuk diverifikasi dan diproses lebih lanjut untuk pendaftaran calon murid ke SLB Patriot Kota Bekasi.
                        </div>
                    @endforeach
                </div>
            </div>

            @php
                $status = $programs->first()->status ?? 'draft';
                $alertClass = match ($status) {
                    'draft' => 'alert-dark',
                    'verifikasi' => 'alert-warning',
                    'diperbaiki' => 'alert-primary',
                    'ditolak' => 'alert-danger',
                    default => 'alert-primary',
                };
            @endphp

            <div class="alert {{ $alertClass }} alert-dismissible mb-4 mt-3 fade show position-relative" role="alert">
                <div class="d-flex">
                    <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>
                    @foreach ($programs as $item)
                        <div class="text-white mt-2">
                            Mohon diperhatikan bahwa perubahan data tidak dapat dilakukan setelah Anda melakukan
                            <strong>Konfirmasi Data</strong>.
                            <br>
                            @php
                                $statusText = $item->status === 'ditolak' ? 'Ditutup' : ucfirst($item->status);
                            @endphp
                            Saat ini, status Program Inovasi Anda adalah: <strong> {{ $statusText }}</strong>.
                            <br>
                            @if (!empty($program) && in_array($program->status, ['verifikasi', 'diterima']))
                                <span type="button" class="btn btn-light-info btn-sm mt-2 fw-bold">
                                    <i class="bi bi-hand-thumbs-up"></i> Anda sudah mengonfirmasi!
                                </span>
                            @elseif (!empty($program) && $program->status === 'ditolak')

                            @elseif (!empty($showFinalProgramAlert) && $showFinalProgramAlert)
                                <button type="button" class="btn btn-light-info btn-sm mt-2 fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#modal-konfirmasi-program">
                                    <i class="bi bi-hand-thumbs-up"></i> Konfirmasi, data sudah benar!
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif ($programs->count())
            <div class="alert alert-info alert-dismissible mb-4 mt-3 fade show position-relative" role="alert">
                <div class="d-flex">
                    <i class="bi-bell-fill text-white fs-1 me-3 flex-shrink-0 align-self-start"></i>

                    <div class="text-white mt-2">
                        <strong>Terima kasih!</strong> Data pendaftaran calon murid SLB telah berhasil disimpan.
                        <br>
                        Setiap akun hanya dapat mendaftarkan maksimal 1 calon murid.
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-9">
                <div class="page-title">
                    <div class="card">
                        <div class="card-body" style="padding-bottom: 1px !important;">
                            <h5>Data Profil <i class="bx bx-user"></i></h5>
                            <small><i>Untuk melihat data Profil lengkap, silahkan ke menu PROFIL SAYA</i></small>
                            <div class="row mt-2">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group"><label>Email</label>
                                        <p class="form-control-static">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group"><label>Nama Orang Tua</label>
                                        <p class="form-control-static">{{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group"><label>Jenis Pengguna</label><b>
                                            <p class="form-control-static">{{ auth()->user()->getRoleNames()[0] }}</p>
                                        </b></div>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group"><label>Bergabung pada</label>
                                        <div class="form-control-static">
                                            {{ Carbon\Carbon::parse(auth()->user()->created_at)->translatedFormat('H:i - l, d F Y') ?? 'N/A' }}
                                            <br><b>ID : {{ auth()->user()->uuid }}</b>
                                            <br>
                                            <button type="button" class="btn icon btn-sm btn-success mt-2 py-1 px-2"
                                                data-bs-toggle="modal" data-bs-target="#profilModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                                </svg> Lihat Profil
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="profilModal" tabindex="-1"
                                                aria-labelledby="profilModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content shadow">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="profilModalLabel">Profil Anda</h5>
                                                            <button type="button" class="btn-close btn-close-dark"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <!-- Ganti dengan data user -->
                                                            <div class="row mb-2">
                                                                <div class="col-md-6">
                                                                    <strong>Nama Orang Tua:</strong>
                                                                    {{ Auth::user()->name ?? 'Nama Anda' }}
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>Email:</strong>
                                                                    {{ Auth::user()->email ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-6">
                                                                    <strong>No. Whatsapp:</strong>
                                                                    {{ Auth::user()->no_hp ?? '-' }}
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <strong>Nama Anak:</strong>
                                                                    {{ Auth::user()->medsos ?? '-' }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!empty($program) && $program->status === 'diperbaiki')
                        <div class="col-lg-12 mb-3">
                            <div class="alert alert-light-dark alert-dismissible mb-4 mt-3 fade show position-relative"
                                role="alert">
                                <div class="d-flex">
                                    <i
                                        class="bi-exclamation-triangle-fill text-dark fs-5 me-3 flex-shrink-0 align-self-start"></i>
                                    <div class="text-dark mt-2">
                                        @foreach ($programs as $item)
                                            <strong>Mohon Maaf !</strong> {{ $item->catatan }}
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true" class="">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                    @endif

                    <div class="row mb-2">
                        <div class="col-lg-6"><strong class="h5 text-muted">Data Siswa</strong><br><small>Informasi
                                Biodata Calon Murid SLB Patriot Kota Bekasi @php
                                    $tahunSekarang = date('Y');
                                    $tahunBerikut = $tahunSekarang + 1;
                                @endphp

                                <strong>Tahun Pelajaran {{ $tahunSekarang }} / {{ $tahunBerikut }}</strong>.</small></div>
                        <div class="col-lg-6">

                            @if (!empty($program) && $program->status === 'hadir')
                                <span type="button" class="btn btn-info btn-md float-end mt-2 text-white">
                                    <i class="bi bi-hand-thumbs-up"></i> Anda sudah mengonfirmasi!
                                </span>
                            @elseif (!empty($program) && $program->status === 'ditolak')
                                <div class="alert alert-danger float-end mt-2 mb-0 py-2 px-3 text-white">
                                    <i class="bi bi-x-circle-fill me-2"></i>
                                    Mohon maaf, pendaftaran sudah <strong>ditutup</strong>.
                                </div>
                            @elseif (!empty($program) && $program->status === 'diterima')
                                {{-- status diterima: tidak menampilkan apapun --}}
                            @elseif (!empty($showFinalProgramAlert) && $showFinalProgramAlert)
                                <button type="button" class="btn btn-info btn-md float-end mt-2 text-white"
                                    data-bs-toggle="modal" data-bs-target="#modal-konfirmasi-program">
                                    <i class="bi bi-hand-thumbs-up"></i> Konfirmasi, data sudah benar!
                                </button>
                                @include('pages.program.modal-konfirmasi')
                            @else
                                @role('user')
                                    <button type="button" class="btn btn-primary btn-md float-end mt-2"
                                        data-bs-toggle="modal" data-bs-target="#modal-form-add-program">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Data
                                    </button>
                                @endrole
                            @endif

                        </div>
                    </div>
                </div>

                @role('admin|super-admin')
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" class="mb-3">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <label for="filter_status" class="col-form-label">Status :</label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="status" id="filter_status" class="form-select"
                                            onchange="this.form.submit()">
                                            <option value="">Semua Status</option>
                                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                            </option>
                                            <option value="verifikasi"
                                                {{ request('status') == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                            <option value="diperbaiki"
                                                {{ request('status') == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                            <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>
                                                Diterima</option>
                                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                                Ditutup</option>
                                        </select>
                                    </div>

                                    {{-- Tombol Reset --}}
                                    <div class="col-auto">
                                        <a href="{{ route('program.index') }}" class="btn btn-danger">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </form>


                            <div class="table-responsive text-nowrap mx-2">
                                <table class="table table table-bordered" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Verifikasi</th>
                                            <th>Dimensi</th>
                                            <th class="text-wrap" style="width: 100px;">Nama Peserta</th>
                                            <th class="text-wrap" style="width: 100px;">Judul Kegiatan</th>
                                            <th>Status</th>
                                            <th>Dokumen Penunjang</th>
                                            <th>Dokumen Pendukung</th>
                                            <th>Detail Program</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($programs as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if ($item->status === 'diterima')
                                                        <i class="bi bi-check-circle-fill text-success fs-5"
                                                            title="Sudah dicek dan diterima"></i>
                                                    @elseif ($item->status === 'ditolak')
                                                        <i class="bi bi-x-circle-fill text-danger fs-5 fs-5"
                                                            title="Sudah dicek dan ditolak"></i>
                                                    @elseif ($item->status === 'diperbaiki')
                                                        <i class="bi bi-exclamation-triangle-fill text-info fs-5 fs-5"
                                                            title="Sudah dicek dan diperbaiki"></i>
                                                    @else
                                                        <i class="bi bi-dash-circle text-secondary fs-5"
                                                            title="Belum diterima"></i>
                                                    @endif
                                                </td>
                                                <td>{{ $item->portofolio->nama }}</td>
                                                <td class="text-wrap" style="width: 100px;">{{ $item->user->name }}</td>
                                                <td class="text-wrap" style="width: 100px;">{{ $item->judul_kegiatan }}</td>
                                                <td>
                                                    @php
                                                        $statusClass = match ($item->status) {
                                                            'draft' => 'btn-secondary',
                                                            'diterima' => 'btn-success',
                                                            'verifikasi' => 'btn-info',
                                                            'diperbaiki' => 'btn-primary',
                                                            'ditolak' => 'btn-danger',
                                                            default => 'btn-secondary',
                                                        };

                                                        $statusText =
                                                            $item->status === 'ditolak'
                                                                ? 'Ditutup'
                                                                : ucfirst($item->status);
                                                    @endphp

                                                    <button type="button" class="btn {{ $statusClass }} btn-sm text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalUpdateStatus-{{ $item->id }}">
                                                        {{ $statusText }}
                                                    </button>

                                                </td>
                                                <td>
                                                    <div class="buttons">
                                                        @if ($item->user && $item->user->surat_pernyataan)
                                                            <button type="button"
                                                                class="btn btn-danger text-white btn-outline-secondary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalSuratPernyataan-{{ $item->id }}">
                                                                Surat Pernyataan
                                                            </button>
                                                        @endif
                                                        <br>
                                                        <button type="button"
                                                            class="btn btn-primary text-white btn-outline-secondary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalProfilKomunitas-{{ $item->id }}">
                                                            Profil Komunitas
                                                        </button>
                                                        <br>
                                                        <button type="button"
                                                            class="btn btn-success text-white btn-outline-secondary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalLogoKomunitas-{{ $item->id }}">
                                                            Logo Peserta
                                                        </button>
                                                    </div>

                                                    @include('pages.program.modals-file-preview')

                                                </td>

                                                <td>
                                                    <div class="buttons">
                                                        @if ($item->video)
                                                            <a href="{{ $item->video }}"
                                                                class="btn btn-info text-white btn-outline-secondary btn-sm"
                                                                target="_blank">
                                                                Materi Video
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Materi Video belum tersedia</span>
                                                        @endif
                                                        <br>

                                                        @if ($item->presentasi)
                                                            <a href="{{ $item->presentasi }}"
                                                                class="btn btn-warning text-white btn-outline-secondary btn-sm"
                                                                target="_blank">
                                                                Materi Kompetisi
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Materi Kompetisi belum tersedia</span>
                                                        @endif

                                                    </div>

                                                </td>

                                                <td>
                                                    @can('program.update')
                                                        <a href="{{ route('program.cetak', ['id' => $item->id, 'uuid' => $item->user_uuid]) }}"
                                                            class="btn btn-icon btn-secondary btn-sm text-white" target="_blank">
                                                            Cetak Kegiatan</a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    @forelse ($programs as $item)
                        <div class="card border-primary mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>Ditambahkan</strong></div>
                                            <div class="col-md-8"><span
                                                    class="badge bg-primary">{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('H:i - l, d F Y') ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>Nama Anak</strong></div>
                                            <div class="col-md-8">{{ $item->nama_anak }}</div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>Disabilitas</strong></div>
                                            <div class="col-md-8"><span
                                                    class="badge bg-info">{{ $item->disabilities->name ?? '-' }}</span></div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-4">
                                                <strong>
                                                    Nama Ayah
                                                    <i class="bi bi-info-circle-fill text-muted ms-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Nama ayah dari anak."></i>
                                                </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <span class="text-muted">{{ $item->nama_ayah }}</span>
                                            </div>
                                        </div>

                                        <div class="row mb-1">
                                            <div class="col-md-4">
                                                <strong>
                                                    Nama Ibu
                                                    <i class="bi bi-info-circle-fill text-muted ms-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Nama ayah dari ibu."></i>
                                                </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <span class="text-muted">{{ $item->nama_ibu }}</span>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="col-md-6">
                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>Status</strong></div>
                                            @php
                                                $badgeClass = 'bg-secondary';
                                                $badgeText = ucfirst($item->status); // Default: tampilkan status asli dengan huruf kapital awal

                                                if ($item->status === 'pending') {
                                                    $badgeClass = 'bg-secondary';
                                                } elseif ($item->status === 'hadir') {
                                                    $badgeClass = 'bg-warning';
                                                } elseif ($item->status === 'reschedule') {
                                                    $badgeClass = 'bg-primary';
                                                } elseif ($item->status === 'ditolak') {
                                                    $badgeClass = 'bg-danger';
                                                    $badgeText = 'Ditutup'; //
                                                } elseif ($item->status === 'diterima') {
                                                    $badgeClass = 'bg-success';
                                                }
                                            @endphp

                                            <div class="col-md-8">
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ $badgeText }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>No. Handphone</strong></div>
                                            <div class="col-md-8">{{ $item->no_hp }}</div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-4"><strong>Catatan</strong></div>
                                            <div class="col-md-8">
                                                Data pendaftaran <strong>SLB Patriot Kota Bekasi</strong> Anda saat ini
                                                masih dalam status
                                                <b>{{ ucfirst($item->status) }}</b>, silakan pantau informasi secara berkala.

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($program && $program->status === 'verifikasi')
                                    <div class="mt-4" <span class="text-muted">*Jika status inovasi sudah
                                        <strong>Diterima</strong>,
                                        akan muncul tombol Cetak.</span>
                                    </div>
                                @elseif (!empty($program) && $program->status === 'ditolak')
                                    <div class="mt-4" <span class="text-muted">*Jika status inovasi sudah
                                        <strong>Ditutup</strong>,
                                        Anda tidak dapat melanjutkan Kompetisi Ekosistem Kota Cerdas.</span>
                                    </div>
                                @elseif (!empty($program) && $program->status === 'diterima')
                                    <div class="col-md-12 text-end mt-4">
                                        <a href="{{ route('program.cetak', ['id' => $item->id, 'uuid' => $item->user_uuid]) }}"
                                            class="btn btn-icon btn-primary text-white" target="_blank">
                                            <i class="bi bi-eye"> Cetak Kegiatan</i>
                                        </a>
                                    </div>
                                @else
                                    <div class="row mt-2 justify-content-between">
                                        <div class="col-md-9">
                                            <div class="buttons">
                                                @if ($item->status === 'diterima')
                                                    <a href="{{ route('program.cetak', ['id' => $item->id, 'uuid' => $item->user_uuid]) }}"
                                                        class="btn btn-outline-primary" target="_blank">Cetak Kegiatan</a>
                                                @else
                                                    @can('program.update')
                                                        @php
                                                            $uuid = $item->user_uuid ?? ($item->user->uuid ?? null);
                                                        @endphp
                                                    @endcan
                                                @endif

                                            </div>
                                            <span class="text-muted mt-2">*Jika sudah konfirmasi <strong>Hadir</strong>,
                                             data tidak bisa diubah.</span>
                                        </div>
                                        @if (
                                            !empty($program) &&
                                                $program->status !== 'hadir' &&
                                                $program->status !== 'diterima' &&
                                                $program->status !== 'ditolak')
                                            <div class="col-md-3 text-end">
                                                <div class="buttons">

                                                    @can('program.update')
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#modal-form-edit-program-{{ $item->uuid }}"
                                                            class="btn btn-icon btn-success text-white">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </a>

                                                        @include('pages.program.modal-edit')
                                                    @endcan

                                                    @can('program.destroy')
                                                        <a onclick="showSweetAlert('{{ $item->uuid }}')" title="Delete"
                                                            class="btn btn-icon btn-danger text-white">
                                                            <i class="bi bi-x-square"></i> Hapus
                                                        </a>

                                                        <form id="deleteForm_{{ $item->uuid }}"
                                                            action="{{ route('program.destroy', $item->uuid) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                        </form>
                                                    @endcan

                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="card border-primary mb-4">
                            <div class="card-body">
                                <p class="text-muted mb-0">Belum ada calon murid yang ditambahkan.</p>
                            </div>
                        </div>
                    @endforelse
                @endrole
            </div>

            <div class="col-md-3">
                <div class="page-title mb-3">Petunjuk :</div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class='bx bx-flag'></i> Tahapan Pendaftaran
                        </h6>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class='bx bx-search-alt-2 text-primary fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Seleksi</h6>
                                    <small class="text-muted">Penilaian awal terhadap berkas dan kriteria calon
                                        peserta.</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class='bx bx-user-check text-success fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Hadir</h6>
                                    <small class="text-muted">Peserta hadir untuk wawancara atau observasi
                                        langsung.</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class='bx bx-time text-warning fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Reschedule</h6>
                                    <small class="text-muted">Jadwal diubah atas kesepakatan peserta atau panitia.</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class='bx bx-badge-check text-info fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Diterima</h6>
                                    <small class="text-muted">Peserta dinyatakan lolos dan diterima resmi.</small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class='bx bx-x-circle text-danger fs-4'></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Tidak Diterima</h6>
                                    <small class="text-muted">Peserta belum memenuhi kriteria penerimaan.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('pages.program.modal-create')

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

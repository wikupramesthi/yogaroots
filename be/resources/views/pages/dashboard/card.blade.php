@extends('layouts.app')

@section('content')
<div class="row">
    @role('super-admin|admin')
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon purple mb-2">
                            <i class='bx bx-user'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Jumlah Pegawai</h6>
                        <a href="{{ route('instruktur.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $jumlahUser }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon blue mb-2">
                            <i class='bx bx-news'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total Berita</h6>
                        <a href="{{ route('articles.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalArticles }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon green mb-2">
                            <i class='bx bx-image'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total Banner</h6>
                        <a href="{{ route('banner.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalBanner }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon red mb-2">
                            <i class='bx bx-file'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total Dokumen</h6>
                        <a href="{{ route('filedownload.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalDokumen }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon yellow mb-2">
                            <i class='bx bx-help-circle'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total FAQ</h6>
                        <a href="{{ route('faq.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalFaq }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon cyan mb-2">
                            <i class='bx bx-poll'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total Polling</h6>
                        <a href="{{ route('poll.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalPolling }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon pink mb-2">
                            <i class='bx bx-envelope'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total Pesan</h6>
                        <a href="{{ route('layanan.kontak') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalPesan }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body px-4 py-4-5">
                <div class="row">
                    <div class="col-md-3 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                        <div class="stats-icon turquoise mb-2">
                            <i class='bx bx-comment-detail'></i>
                        </div>
                    </div>
                    <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                        <h6 class="text-muted font-semibold">Total Testimoni</h6>
                        <a href="{{ route('testimonial.index') }}" class="text-decoration-none">
                            <h6 class="font-extrabold mb-0">{{ $totalTestimonial }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-12 col-lg-9">
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-uppercase mb-1">Informasi Pendaftaran</h4>
                    <h5 class="text-primary fw-semibold mb-1">SLB Patriot Kota Bekasi</h5>
                    @php
                    $tahunSekarang = date('Y');
                    $tahunBerikut = $tahunSekarang + 1;
                    @endphp

                    <h6 class="text-muted">Tahun Pelajaran {{ $tahunSekarang }} / {{ $tahunBerikut }}</h6>
                </div>

                <hr class="mb-4">

                <div class="card bg-light border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary">Syarat-Syarat Pendaftaran:</h5>
                        <ol class="lh-lg">
                            <li>Mengisi formulir pendaftaran.</li>
                            <li>Fotokopi Akte Kelahiran.</li>
                            <li>Fotokopi Kartu Keluarga.</li>
                            <li>Fotokopi KTP Orang Tua.</li>
                            <li>Ijasah Terakhir (bagi calon PDB SMPLB/SMALB).</li>
                            <li>Pas foto 3 x 4 (2 lembar).</li>
                            <li>Hasil Test IQ.</li>
                            <li>Surat Keterangan Disabilitas dari Dokter.</li>
                            <li>Surat Keterangan Pindah (bagi calon PDB Mutasi).</li>
                        </ol>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-success">Rincian Biaya Pendidikan:</h5>
                        <ul class="lh-lg mb-0">
                            <li>Uang Pendaftaran : <span class="fw-semibold text-dark">Rp 250.000,-</span></li>
                            <li>Uang Awal Tahun : <span class="fw-semibold text-dark">Rp 2.500.000,-</span></li>
                            <li>Uang Bulanan : <span class="fw-semibold text-dark">Rp 400.000,- / bulan</span></li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('program.index') }}"
                        class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm">
                        <i class='bx bx-download'></i> Daftar Sekarang
                    </a>
                </div>

            </div>
        </div>
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
                            <small class="text-muted">Peserta hadir untuk wawancara atau observasi langsung.</small>
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

    @php
    $user = Auth::user();
    @endphp

    @if ($user && ($user->role === 'user' || $user->hasRole('user')) && empty($user->no_hp))
    <div class="modal fade" id="sumberModal" tabindex="-1" aria-labelledby="sumberModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('dashboard.submitSumber') }}" method="POST">
                @csrf
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title">Silakan masukkan No. WhatsApp aktif Anda</h5>
                    </div>

                    <div class="form-group mt-3">
                        <label for="no_hp" class="form-label">Nomor Telepon (WA Aktif)</label>
                        <div class="input-group mt-1">
                            <span class="input-group-text">+62</span>
                            <input
                                type="text"
                                name="no_hp"
                                id="no_hp"
                                class="form-control"
                                placeholder="85612345678"
                                required
                                pattern="[0-9]{8,15}">
                        </div>
                        <small class="text-muted">
                            Masukkan nomor tanpa 0 di depan. Contoh: 85612345678
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('sumberModal'));
            modal.show();
        });
    </script>
    @endif

    @if (session('success'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('
                success ') }}',
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
    @endif

    @endrole
</div>
@endsection
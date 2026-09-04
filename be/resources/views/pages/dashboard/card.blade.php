@extends('layouts.app')

@section('content')
<div class="row">
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
                            <h6 class="font-extrabold mb-0"></h6>
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
                            <h6 class="font-extrabold mb-0"></h6>
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

    @endsection
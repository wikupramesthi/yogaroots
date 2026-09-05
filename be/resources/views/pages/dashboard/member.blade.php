@extends('layouts.app')

@section('content')

<style>
    .hero-panel {
        background: var(--brand-gradient);
        border-radius: var(--bs-border-radius-xl);
        color: #fff;
        padding: 1.8rem 2rem;
        position: relative;
        overflow: hidden;
    }

    .hero-panel::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .08);
    }

    .hero-panel::before {
        content: "";
        position: absolute;
        right: 60px;
        bottom: -70px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .membership-card {
        position: relative;
        overflow: hidden;
        padding: 24px;
        background: linear-gradient(135deg,
                #ffffff 0%,
                #f8f7ff 100%);
        border: 1px solid #eceaff;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.06);
        transition: all 0.3s ease;
    }

    .membership-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(79, 70, 229, 0.12);
    }


    /* Header */

    .membership-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .membership-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: #fff;
        font-size: 19px;
        background: linear-gradient(135deg,
                #4f46e5,
                #7c3aed);
        box-shadow: 0 5px 12px rgba(79, 70, 229, 0.25);
    }

    .membership-status {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        border-radius: 50px;
        color: #15803d;
        background: #dcfce7;
        font-size: 12px;
        font-weight: 600;
    }


    /* Plan */

    .membership-plan {
        position: relative;
        overflow: hidden;
        padding: 16px;
        margin-bottom: 18px;
        border-radius: 15px;
        background: linear-gradient(135deg,
                #eef2ff,
                #f5f3ff);
    }

    .membership-plan-name {
        margin-top: 3px;
        color: #5b4ce1;
        font-size: 20px;
        font-weight: 700;
    }

    .membership-stars {
        position: absolute;
        top: 12px;
        right: 16px;
        color: #7c3aed;
        font-size: 42px;
        opacity: 0.12;
    }


    /* Credit */

    .membership-credit {
        margin-top: 5px;
    }

    .membership-progress {
        width: 100%;
        height: 9px;
        overflow: hidden;
        border-radius: 20px;
        background: #e9e7ff;
    }

    .membership-progress-bar {
        width: 67%;
        height: 100%;
        border-radius: 20px;
        background: linear-gradient(90deg,
                #4f46e5,
                #8b5cf6);
    }


    /* Button */

    .membership-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin-top: 18px;
        padding: 11px 16px;
        border-radius: 12px;
        color: #fff;
        background: linear-gradient(135deg,
                #4f46e5,
                #7c3aed);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .membership-icon i {
        width: auto;
        height: auto;
    }

    .membership-button:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
    }
</style>

<div class="container-fluid pb-5">
    <!-- Hero -->
    <div class="hero-panel mb-4">
        <div class="row align-items-center position-relative">
            <div class="col-lg-9">
                <div class="badge bg-white bg-opacity-25 mb-2 px-3 py-2 rounded-pill">{{ now()->translatedFormat('l, j F Y') }}</div>
                <h3 class="fw-bold text-white mb-1">Halo, {{ auth()->user()->name }} 🌸</h3>
                <p class="text-white-50 mb-0">
                    Discover useful tips and interesting information today. There are plenty of new things to learn and explore.
                </p>
            </div>
            <div class="col-lg-3 text-lg-end mt-3 mt-lg-0" style="position: relative;z-index: 1;">
                <a href="{{ route('packages.member') }}" class="btn btn-light fw-bold px-4"><i class="bi bi-calendar-check me-1"></i> Select Your Plan</a>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row">

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
                            <h6 class="text-muted font-semibold">Total Classes</h6>
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
                                <i class='bx bxs-calendar'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Events</h6>
                            <span class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $totalEvents }}</h6>
                            </span>
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
                                <i class='bx bx-user'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Instructors</h6>
                            <span class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $jumlahInstruktur }}</h6>
                            </span>
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
                                <i class='bx bx-user-check'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Members</h6>
                            <span class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $jumlahMembers }}</h6>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Kelas berikutnya -->
        <div class="col-lg-7">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="color:var(--bs-heading-color);">Upcoming Classes</h6>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-circle lg">RA</div>
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="color:var(--bs-heading-color);">Vinyasa Flow — Level Menengah</div>
                            <div class="small text-secondary"><i class="bi bi-person me-1"></i>Instruktur Rani Anjani</div>
                            <div class="small text-secondary"><i class="bi bi-clock me-1"></i>07:30 – 08:30 WIB &nbsp;•&nbsp; <i class="bi bi-geo-alt me-1"></i>Studio 2, Lantai 3</div>
                        </div>
                        <a href="#" class="btn btn-primary d-none d-md-inline-block">Gabung Kelas</a>
                    </div>
                    <a href="#" class="btn btn-primary w-100 d-md-none mt-3">Gabung Kelas</a>
                </div>
            </div>
        </div>

        <!-- Membership -->
        <div class="col-lg-5" id="membership">
            <div class="membership-card h-100">

                <div class="membership-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="membership-icon">
                            <i class="bi bi-gem"></i>
                        </div>

                        <div>
                            <h6 class="fw-bold mb-0">Membership Plan</h6>
                            <small class="text-secondary">Your current membership</small>
                        </div>
                    </div>

                    <span class="membership-status">
                        <i class="bi bi-check-circle me-1"></i>
                        Active
                    </span>
                </div>

                <div class="membership-plan">
                    <div>
                        <small class="text-secondary">Current Plan</small>
                        <div class="membership-plan-name">
                            Premium Monthly
                        </div>
                    </div>

                    <i class="bi bi-stars membership-stars"></i>

                    <div class="small text-secondary mt-2">
                        <i class="bi bi-calendar3 me-1"></i>
                        Valid until 28 September 2026
                    </div>
                </div>

                <div class="membership-credit">
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-secondary">
                            <i class="bi bi-ticket-perforated me-1"></i>
                            Class credits used
                        </span>

                        <span class="fw-bold">8 / 12</span>
                    </div>

                    <div class="membership-progress">
                        <div class="membership-progress-bar"></div>
                    </div>

                    <div class="small text-secondary mt-2">
                        4 class credits remaining
                    </div>
                </div>

                <a href="#" class="membership-button">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    Renew Membership
                </a>

            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8" id="jadwal">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="color:var(--bs-heading-color);">Today’s Schedule</h6>
                        <a href="#" class="small fw-semibold text-decoration-none">View All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Kelas</th>
                                    <th>Hari &amp; Waktu</th>
                                    <th>Instruktur</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Vinyasa Flow</td>
                                    <td>Kamis, 07:30</td>
                                    <td>Rani Anjani</td>
                                    <td>Menengah</td>
                                    <td><span class="badge alert-light-primary">Terdaftar</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Yin Yoga &amp; Meditasi</td>
                                    <td>Jumat, 18:00</td>
                                    <td>Bagas Prakoso</td>
                                    <td>Semua Level</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary-emphasis">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Hatha Yoga Dasar</td>
                                    <td>Sabtu, 08:00</td>
                                    <td>Wulan Kusuma</td>
                                    <td>Pemula</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary-emphasis">Tersedia</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Power Yoga</td>
                                    <td>Minggu, 06:30</td>
                                    <td>Rani Anjani</td>
                                    <td>Lanjutan</td>
                                    <td><span class="badge bg-warning-subtle text-warning-emphasis">2 slot tersisa</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress -->
        <div class="col-lg-4" id="progress">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="color:var(--bs-heading-color);">
                            Upcoming Events
                        </h6>
                    </div>

                    <!-- Event 1 -->
                    @foreach ($events as $event)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <div class="fw-semibold">
                                {{ $event->judul }}
                            </div>

                            <small class="text-secondary">
                                {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}

                                @if ($event->waktu_mulai)
                                · {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                                @endif
                            </small>
                        </div>

                        <button class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#eventModal{{ $event->id }}">
                            Detail
                        </button>
                    </div>
                    @endforeach
                </div>

                <!-- Modal Event 1 -->
                @foreach ($events as $event)
                <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">

                            {{-- Gambar Event --}}
                            @if ($event->gambar)
                            <img src="{{ asset('storage/' . $event->gambar) }}"
                                class="img-fluid"
                                alt="{{ $event->judul }}"
                                style="max-height: 300px; object-fit: cover;">
                            @endif

                            <div class="modal-header">
                                <h5 class="modal-title">
                                    {{ $event->judul }}
                                </h5>

                                <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="modal-body">

                                <p class="mb-2">
                                    <strong>Date:</strong>
                                    {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}
                                </p>

                                <p class="mb-2">
                                    <strong>Time:</strong>

                                    @if ($event->waktu_mulai)
                                    {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}

                                    @if ($event->waktu_selesai)
                                    - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                                    @endif
                                    @else
                                    -
                                    @endif
                                </p>

                                <p class="mb-2">
                                    <strong>Location:</strong>
                                    {{ $event->lokasi ?? '-' }}
                                </p>

                                @if ($event->kapasitas)
                                <p class="mb-2">
                                    <strong>Capacity:</strong>
                                    {{ $event->kapasitas }} Members
                                </p>
                                @endif

                                @if ($event->deskripsi)
                                <div class="mt-3">
                                    {!! $event->deskripsi !!}
                                </div>
                                @elseif ($event->excerpt)
                                <p class="mt-3 mb-0">
                                    {{ $event->excerpt }}
                                </p>
                                @endif

                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
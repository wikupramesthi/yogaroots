@extends('layouts.app')

@section('content')

    <div class="card text-white mb-3" style="background: var(--brand-gradient);">
      <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
          <span class="badge bg-white text-dark mb-2"> {{ now()->translatedFormat('l, j F Y') }}</span>
          <h3 class="text-white fw-bold mb-1">Halo, {{ auth()->user()->name }} 🌿</h3>
          <div class="text-white-50">A quick overview of today’s studio activities and performance.</div>
        </div>
        <button class="btn btn-light"><i class="bi bi-bar-chart me-1"></i>  View Reports</button>
      </div>
    </div>
    
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
                            <h6 class="text-muted font-semibold">Total Member</h6>
                            <a href="{{ route('pengguna.index') }}" class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $jumlahMembers }}</h6>
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
                                <i class='bx bi-people'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Instructors</h6>
                            <a href="{{ route('instruktur.index') }}" class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $jumlahInstruktur }}</h6>
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
                                <i class='bx bx-package'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Packages</h6>
                            <a href="{{ route('packages.index') }}" class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $totalPackages }}</h6>
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
                                <i class='bx bx-book'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Class</h6>
                            <a href="{{ route('classes.index') }}" class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $totalClasses }}</h6>
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
                                <i class='bx bx-file'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Articles</h6>
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
                            <div class="stats-icon pink mb-2">
                                <i class='bx bx-envelope'></i>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-12 col-xl-12 col-xxl-8">
                            <h6 class="text-muted font-semibold">Total Messages</h6>
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
                            <h6 class="text-muted font-semibold">Testimonials</h6>
                            <a href="{{ route('testimonial.index') }}" class="text-decoration-none">
                                <h6 class="font-extrabold mb-0">{{ $totalTestimonial }}</h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-transparent">
                <h5 class="card-title mb-0">Today's Bookings</h5>
            </div>

            <div class="card-body">
                <div class="list-group list-group-flush">

                    <div class="list-group-item d-flex align-items-center gap-3 px-0">
                        <div class="fw-bold text-primary" style="width:56px;">06:00</div>

                        <div class="flex-grow-1">
                            <div class="fw-semibold">Morning Hatha Yoga</div>
                            <div class="small text-muted">
                                Dewi Anggraini · Studio 1
                            </div>
                        </div>

                        <span class="badge bg-light-secondary">14 / 18</span>
                    </div>

                    <div class="list-group-item d-flex align-items-center gap-3 px-0">
                        <div class="fw-bold text-primary" style="width:56px;">08:00</div>

                        <div class="flex-grow-1">
                            <div class="fw-semibold">Vinyasa Flow</div>
                            <div class="small text-muted">
                                Bagus Prasetyo · Studio 2
                            </div>
                        </div>

                        <span class="badge bg-light-danger">Full</span>
                    </div>

                    <div class="list-group-item d-flex align-items-center gap-3 px-0">
                        <div class="fw-bold text-primary" style="width:56px;">10:30</div>

                        <div class="flex-grow-1">
                            <div class="fw-semibold">Prenatal Yoga</div>
                            <div class="small text-muted">
                                Dewi Anggraini · Studio 1
                            </div>
                        </div>

                        <span class="badge bg-light-secondary">9 / 12</span>
                    </div>

                    <div class="list-group-item d-flex align-items-center gap-3 px-0">
                        <div class="fw-bold text-primary" style="width:56px;">17:00</div>

                        <div class="flex-grow-1">
                            <div class="fw-semibold">Yin Yoga & Relaxation</div>
                            <div class="small text-muted">
                                Rangga Kusuma · Studio 2
                            </div>
                        </div>

                        <span class="badge bg-light-secondary">16 / 18</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex gap-2 align-items-center">

                    <div class="avatar avatar-md2">
                        <div class="avatar-content bg-primary">
                            <i class="bi bi-journal-check"></i>
                        </div>
                    </div>

                    <div>
                        <h6 class="mb-0">Booking Summary</h6>
                        <div class="small text-muted">Today</div>
                    </div>

                </div>

                <span class="badge bg-light-primary">37 Total</span>
            </div>

            <div class="list-group list-group-flush mb-3">

                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>
                        <i class="bi bi-check-circle text-success me-2"></i>
                        Confirmed
                    </span>
                    <span class="fw-bold">28</span>
                </div>

                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>
                        <i class="bi bi-clock text-warning me-2"></i>
                        Pending
                    </span>
                    <span class="fw-bold">6</span>
                </div>

                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <span>
                        <i class="bi bi-x-circle text-danger me-2"></i>
                        Cancelled
                    </span>
                    <span class="fw-bold">3</span>
                </div>

            </div>

            <button class="btn btn-primary w-100">
                <i class="bi bi-journal-check me-1"></i>
                View All Bookings
            </button>

        </div>
    </div>
</div>
  </div>

   <div class="row">
    <div class="col-lg-8">
        <div class="card">

            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Today's Class Schedule</h5>

                <a href="#" class="small text-decoration-none text-primary fw-semibold">
                    View All
                </a>
            </div>

            <div class="card-body table-responsive">
                <table class="table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>CLASS</th>
                            <th>TIME</th>
                            <th>INSTRUCTOR</th>
                            <th>LEVEL</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Morning Hatha Yoga</td>
                            <td>Tuesday, 06:00</td>
                            <td>Dewi Anggraini</td>
                            <td>Beginner</td>
                            <td class="fw-bold">Available</td>
                        </tr>

                        <tr>
                            <td>Vinyasa Flow</td>
                            <td>Tuesday, 08:00</td>
                            <td>Bagus Prasetyo</td>
                            <td>Intermediate</td>
                            <td class="fw-bold">Full</td>
                        </tr>

                        <tr>
                            <td>Prenatal Yoga</td>
                            <td>Tuesday, 10:30</td>
                            <td>Dewi Anggraini</td>
                            <td>Beginner</td>
                            <td class="fw-bold">Available</td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <div class="col-lg-4">
     <div class="card">

        <div class="card-header bg-transparent">
            <h5 class="card-title mb-0">Recent Activity</h5>
        </div>

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                <div>
                    <div class="fw-semibold small">New Member</div>
                    <div class="small text-muted">
                        Fajar Nugroho joined at 09:12
                    </div>
                </div>

                <a href="#" class="btn btn-outline-primary btn-sm">
                    View
                </a>
            </div>

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-semibold small">Payment Received</div>
                    <div class="small text-muted">
                        Andra Wijaya · Premium Monthly
                    </div>
                </div>

                <a href="#" class="btn btn-outline-primary btn-sm">
                    View
                </a>
            </div>

        </div>
    </div>
</div>
   </div>
@endsection

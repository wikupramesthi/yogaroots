@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')

    <x-breadcrumb title="Profile" page="User Management" active="Profile" route="{{ route('profile.edit') }}" />

@endsection

@section('content')

    {{-- Password Error --}}
    @if ($errors->updatePassword->any())

        @foreach ($errors->updatePassword->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                {{ $error }}

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>

            </div>
        @endforeach

    @endif


    {{-- Profile Header --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">

            <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                {{-- Avatar --}}
                <div class="flex-shrink-0">

                    <img src="{{ Auth::user()->avatar
                        ? (Str::startsWith(Auth::user()->avatar, 'http')
                            ? Auth::user()->avatar
                            : asset('storage/' . Auth::user()->avatar))
                        : asset('dist/assets/compiled/jpg/avatar.jpg') }}"
                        alt="{{ auth()->user()->name }}" class="rounded-circle border border-3 border-light shadow-sm"
                        style="width: 100px; height: 100px; object-fit: cover;">

                </div>


                {{-- User Info --}}
                <div class="flex-grow-1 text-center text-md-start">

                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-2 mb-2">

                        <h3 class="fw-semibold mb-0">
                            {{ auth()->user()->name }}
                        </h3>

                        @if (auth()->user()->getRoleNames()->isNotEmpty())
                            <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                {{ ucfirst(auth()->user()->getRoleNames()[0]) }}
                            </span>
                        @endif

                    </div>

                    <p class="text-muted mb-3">
                        <i class="bi bi-envelope me-1"></i>
                        {{ auth()->user()->email }}
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">

                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Active Account
                        </span>

                        <span class="badge rounded-pill bg-light text-muted border px-3 py-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            Joined
                            {{ auth()->user()->created_at->format('d M Y') }}
                        </span>

                    </div>

                </div>


                {{-- Actions --}}
                <div class="d-flex flex-column flex-sm-row gap-2">

                    <a href="{{ route('account.index') }}" class="btn btn-primary px-4">

                        <i class="bi bi-pencil-square me-1"></i>
                        Edit Profile

                    </a>

                    <button type="button" class="btn btn-secondary border px-4" data-bs-toggle="modal"
                        data-bs-target="#modal-form-edit-password-{{ auth()->user()->id }}">

                        <i class="bi bi-lock me-1"></i>
                        Change Password

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- Profile Information --}}
    <div class="row g-4">

        {{-- Personal Information --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="mb-4">

                        <h5 class="fw-semibold mb-1">
                            Personal Information
                        </h5>

                        <small class="text-muted">
                            Your basic personal information
                        </small>

                    </div>


                    <div class="row g-3">

                        {{-- Full Name --}}
                        <div class="col-md-6">

                            <div class="bg-primary-subtle rounded-3 p-3 h-100">

                                <small class="text-primary d-block mb-1">
                                    Full Name
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ auth()->user()->name }}
                                </div>

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="col-md-6">

                            <div class="bg-info-subtle rounded-3 p-3 h-100">

                                <small class="text-info-emphasis d-block mb-1">
                                    Email Address
                                </small>

                                <div class="fw-semibold text-dark text-break">
                                    {{ auth()->user()->email }}
                                </div>

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="col-md-6">

                            <div class="bg-success-subtle rounded-3 p-3 h-100">

                                <small class="text-success d-block mb-1">
                                    Phone Number
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ auth()->user()->no_hp ?? '-' }}
                                </div>

                            </div>

                        </div>


                        {{-- Gender --}}
                        <div class="col-md-6">

                            <div class="bg-warning-subtle rounded-3 p-3 h-100">

                                <small class="text-warning-emphasis d-block mb-1">
                                    Gender
                                </small>

                                <div class="fw-semibold text-dark">
                                    {{ $user->jenis_kelamin === 'L' ? 'Male' : ($user->jenis_kelamin === 'P' ? 'Female' : '-') }}
                                </div>

                            </div>

                        </div>


                        {{-- Birth Place --}}
                        <div class="col-md-6">

                            <div class="bg-light border rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    Place of Birth
                                </small>

                                <div class="fw-semibold">
                                    {{ auth()->user()->tempat_lahir ?? '-' }}
                                </div>

                            </div>

                        </div>


                        {{-- Birth Date --}}
                        <div class="col-md-6">

                            <div class="bg-light border rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    Date of Birth
                                </small>

                                <div class="fw-semibold">

                                    @if (auth()->user()->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d M Y') }}
                                    @else
                                        -
                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Religion --}}
                        <div class="col-md-6">

                            <div class="bg-light border rounded-3 p-3 h-100">

                                <small class="text-muted d-block mb-1">
                                    Religion
                                </small>

                                <div class="fw-semibold">
                                    {{ auth()->user()->agama ?? '-' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Account Information --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="mb-4">

                        <h5 class="fw-semibold mb-1">
                            Account Information
                        </h5>

                        <small class="text-muted">
                            Account details and security
                        </small>

                    </div>


                    {{-- Role --}}
                    <div class="bg-primary-subtle rounded-3 p-3 mb-3">

                        <small class="text-primary d-block mb-1">
                            Account Role
                        </small>

                        <div class="fw-semibold">

                            {{ auth()->user()->getRoleNames()->isNotEmpty() ? ucfirst(auth()->user()->getRoleNames()[0]) : '-' }}

                        </div>

                    </div>


                    {{-- Member Since --}}
                    <div class="bg-success-subtle rounded-3 p-3 mb-3">

                        <small class="text-success d-block mb-1">
                            Member Since
                        </small>

                        <div class="fw-semibold">
                            {{ auth()->user()->created_at->format('d M Y') }}
                        </div>

                    </div>


                    {{-- Account Status --}}
                    <div class="bg-info-subtle rounded-3 p-3 mb-3">

                        <small class="text-info-emphasis d-block mb-1">
                            Account Status
                        </small>

                        <span class="badge rounded-pill bg-success px-3 py-2">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Active
                        </span>

                    </div>


                    {{-- Security --}}
                    <div class="border rounded-3 p-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="bg-light rounded-3 p-2">

                                <i class="bi bi-shield-lock fs-5 text-primary"></i>

                            </div>

                            <div>

                                <div class="fw-semibold">
                                    Account Security
                                </div>

                                <small class="text-muted">
                                    Keep your password secure
                                </small>

                            </div>

                        </div>

                        <button type="button" class="btn btn-light border w-100 mt-3" data-bs-toggle="modal"
                            data-bs-target="#modal-form-edit-password-{{ auth()->user()->id }}">

                            <i class="bi bi-key me-1"></i>
                            Change Password

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>


    @include('profile.partials.change-password')

@endsection

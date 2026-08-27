@extends('layouts.auth')
@section('title', 'Login')
@section('content')

    <div class="login-container">
    <div class="background-image"></div>
        <div class="login-card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="logo-container">
                        <i class="bi bi-stars text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h2 class="title-gradient mb-2">Selamat Datang</h2>
                    <p class="text-muted-custom mb-0">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if ($errors->has('email'))
                    <p class="mb-2 text-sm text-danger">The email address or password is incorrect.</p>
                @endif

                    <form method="POST" id="loginForm" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                        <label for="email" class="form-label text-light-custom">Email</label>
                        <div class="input-group">
                            <i class="bi bi-envelope input-icon"></i>
                            <input name="email" type="email" class="form-control" id="email" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-light-custom">Password</label>
                        <div class="input-group">
                            <i class="bi bi-lock input-icon"></i>
                            <input name="password" type="password" class="form-control" id="password" placeholder="Masukkan password"
                                required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label text-muted-custom" for="remember">
                                Ingat saya
                            </label>
                        </div>
                        <a href="#" class="link-primary">Lupa password?</a>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-elegant w-100 mb-4">
                        <span class="login-text">Masuk</span>
                        <span class="loading-text d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Masuk
                        </span>
                    </button>
                    
                </form>
            </div>
        </div>
    </div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    @if($errors->has('email'))
        <div class="toast show" id="errorToast">
            <div class="toast-header bg-danger text-white">
                <i class="bi bi-x-circle-fill me-2"></i>
                <strong class="me-auto">Login Gagal</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-dark text-light">
                {{ $errors->first('email') }}
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="toast show" id="successToast">
            <div class="toast-header bg-success text-white">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong class="me-auto">Login Berhasil</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body bg-dark text-light">
                {{ session('success') }}
            </div>
        </div>
    @endif
</div>


@endsection

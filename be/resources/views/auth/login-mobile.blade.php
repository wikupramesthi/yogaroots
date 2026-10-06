@extends('layouts.mobile')
@section('title', 'Login')
@section('content')

<section class="screen active" id="login">
    <div class="px-4 pt-4">

        {{-- Logo --}}
        <div class="text-center mt-3 mb-1">
            <img src="{{ asset('img/logo-yogaroots.png') }}"
                alt="YogaRoots"
                style="height: 44px; width: auto; object-fit: contain;">
        </div>

        {{-- Header --}}
        <p class="eyebrow mb-1 mt-4">Welcome Back</p>
        <h1 class="fw-semibold mb-1" style="font-size: 28px; line-height: 1.15;">
            Align your breath,<br>body, and soul.
        </h1>
        <p class="small text-muted2 mb-4">
            Sign in to book your classes and continue your journey toward greater balance and well-being.
        </p>

        {{-- Error umum (email/password salah / sesi habis / Google gagal) --}}
        @if ($errors->has('email'))
            <div class="alert alert-danger py-2 px-3 small" role="alert">
                The email address or password is incorrect.
            </div>
        @endif
        @if ($errors->has('session_expired'))
            <div class="alert alert-warning py-2 px-3 small" role="alert">
                {{ $errors->first('session_expired') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger py-2 px-3 small" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success py-2 px-3 small" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{-- Form email --}}
        <div class="app-card p-4 mb-3">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold mb-1">Email Address</label>
                    <input name="email" id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Your email" value="{{ old('email') }}"
                        required autofocus autocomplete="username">
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label small fw-semibold mb-1">Password</label>
                    <div class="input-group">
                        <input name="password" id="password" type="password"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your password"
                            required autocomplete="current-password">
                        <button type="button" class="btn btn-outline-secondary" id="eyeBtn"
                            aria-label="Show password" style="border-radius: 0 14px 14px 0;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="text-small text-decoration-none" style="color: var(--sage);">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-sage w-100 py-2">
                    Sign in
                </button>
            </form>
        </div>

        {{-- Divider --}}
        <div class="d-flex align-items-center gap-2 my-3 px-1">
            <span class="flex-fill" style="height: 1px; background: var(--line);"></span>
            <span class="text-small text-muted2">or sign in with</span>
            <span class="flex-fill" style="height: 1px; background: var(--line);"></span>
        </div>

        {{-- Google --}}
        <a href="{{ url('auth/google') }}"
            class="app-card d-flex align-items-center justify-content-center gap-2 py-3 mb-2 text-decoration-none fw-semibold"
            style="color: var(--fg); font-size: 14px;">
            <svg width="18" height="18" viewBox="0 0 48 48">
                <path fill="#FFC107"
                    d="M43.6 20.5H42V20H24v8h11.3C33.9 32.9 29.4 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z" />
                <path fill="#FF3D00"
                    d="M6.3 14.7l6.6 4.8C14.6 16 19 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 16.3 4 9.7 8.3 6.3 14.7z" />
                <path fill="#4CAF50"
                    d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.4 35 26.8 36 24 36c-5.3 0-9.8-3.1-11.3-7.5l-6.5 5C9.5 39.6 16.2 44 24 44z" />
                <path fill="#1976D2"
                    d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4.1 5.5l6.3 5.3C39.9 36.5 44 30.9 44 24c0-1.3-.1-2.7-.4-3.5z" />
            </svg>
            Sign in with Google
        </a>

        <p class="text-center text-small text-muted2 mt-3 mb-1">
            Begin your wellness journey with <strong>YogaRoots</strong>
        </p>
    </div>
</section>

@push('after-script')
<script>
    (function () {
        var eyeBtn = document.getElementById('eyeBtn');
        var eyeIcon = document.getElementById('eyeIcon');
        var passwordInput = document.getElementById('password');
        if (!eyeBtn || !passwordInput) return;
        eyeBtn.addEventListener('click', function () {
            var show = passwordInput.type === 'password';
            passwordInput.type = show ? 'text' : 'password';
            eyeBtn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            eyeIcon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    })();
</script>
@endpush
@endsection

@extends('layouts.auth')
@section('title', 'Login')
@section('content')

<div class="logo-row">
    <div class="logo-mark">
        <img src="{{ asset('img/logo-yogaroots.png') }}" alt="logo yogaroots">
    </div>
</div>

<div class="layout">
    <div class="intro">
        <p class="eyebrow"><span class="dash"></span>Selamat datang kembali</p>
        <h1>Selaraskan napas,<br><em>tubuh</em>, dan jiwamu.</h1>
        <p class="lead">Masuk untuk memesan kelas, mengikuti jadwal latihan, dan melanjutkan perjalanan menuju keseimbangan yang lebih utuh.</p>

        <div class="stat-row">
            <div class="stat"><strong>500+</strong><span>Anggota aktif</span></div>
            <div class="stat-divider"></div>
            <div class="stat"><strong>12</strong><span>Instruktur bersertifikat</span></div>
            <div class="stat-divider"></div>
            <div class="stat"><strong>4.9</strong><span>Rating dari member</span></div>
        </div>

        <div class="feature-grid">
            <div class="feature">
                <div class="icon-wrap">
                    <svg width="84" height="84" viewBox="0 0 84 84" fill="none">
                        <path d="M12 46c-3-14 8-28 24-27 15 1 24 13 22 26-2 12-13 20-26 19-12-1-18-9-20-18z" fill="#8a9a7e" opacity="0.16" />
                        <circle cx="63" cy="20" r="4" fill="#b96a4b" opacity="0.35" />
                        <rect x="30" y="24" width="20" height="34" rx="4" fill="#fff" stroke="#2b3d2f" stroke-width="1.6" />
                        <rect x="34" y="18" width="12" height="8" rx="2" fill="#b96a4b" />
                        <line x1="34" y1="34" x2="46" y2="34" stroke="#8a9a7e" stroke-width="1.6" stroke-linecap="round" />
                        <line x1="34" y1="40" x2="46" y2="40" stroke="#8a9a7e" stroke-width="1.6" stroke-linecap="round" />
                        <line x1="34" y1="46" x2="42" y2="46" stroke="#8a9a7e" stroke-width="1.6" stroke-linecap="round" />
                        <circle cx="41" cy="53" r="3" fill="#b96a4b" />
                        <circle cx="20" cy="62" r="2" fill="#2b3d2f" opacity="0.3" />
                    </svg>
                </div>
                <h3>Jadwal &amp; Booking Kelas</h3>
                <p>Pilih kelas Alignment, Vinyasa, hingga FeetUp sesuai waktumu.</p>
            </div>
            <div class="feature">
                <div class="icon-wrap">
                    <svg width="84" height="84" viewBox="0 0 84 84" fill="none">
                        <path d="M14 50c-4-15 7-30 26-29 16 1 25 14 22 27-3 13-15 21-28 20-13-1-18-9-20-18z" fill="#b96a4b" opacity="0.14" />
                        <circle cx="18" cy="18" r="3.5" fill="#8a9a7e" opacity="0.4" />
                        <circle cx="42" cy="26" r="6" fill="#2b3d2f" />
                        <path d="M42 32c-9 0-14 6-14 14v8h28v-8c0-8-5-14-14-14z" fill="#b96a4b" />
                        <path d="M28 46c-5 3-7 8-6 13" stroke="#2b3d2f" stroke-width="2" stroke-linecap="round" fill="none" />
                        <path d="M56 46c5 3 7 8 6 13" stroke="#2b3d2f" stroke-width="2" stroke-linecap="round" fill="none" />
                        <path d="M34 20c2-4 6-6 8-6s6 2 8 6" stroke="#8a9a7e" stroke-width="1.8" stroke-linecap="round" fill="none" />
                    </svg>
                </div>
                <h3>Instruktur Berpengalaman</h3>
                <p>Dibimbing langsung oleh instruktur bersertifikat dan penuh perhatian.</p>
            </div>
            <div class="feature">
                <div class="icon-wrap">
                    <svg width="84" height="84" viewBox="0 0 84 84" fill="none">
                        <path d="M13 47c-3-15 9-29 25-28 16 1 24 14 22 27-2 12-14 20-27 19-12-1-17-9-20-18z" fill="#2b3d2f" opacity="0.1" />
                        <line x1="24" y1="60" x2="60" y2="60" stroke="#2b3d2f" stroke-width="2" stroke-linecap="round" />
                        <rect x="29" y="44" width="8" height="16" rx="1.5" fill="#8a9a7e" />
                        <rect x="40" y="34" width="8" height="26" rx="1.5" fill="#b96a4b" />
                        <rect x="51" y="24" width="8" height="36" rx="1.5" fill="#2b3d2f" />
                        <circle cx="55" cy="16" r="3" fill="#b96a4b" opacity="0.5" />
                        <path d="M28 30l7 5 8-9 9 5" stroke="#b96a4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                    </svg>
                </div>
                <h3>Catatan Progres Latihan</h3>
                <p>Pantau kehadiran dan perkembangan praktikmu dari waktu ke waktu.</p>
            </div>
            <div class="feature">
                <div class="icon-wrap">
                    <svg width="84" height="84" viewBox="0 0 84 84" fill="none">
                        <path d="M15 49c-4-15 8-29 25-28 16 1 24 14 21 27-3 12-14 20-27 19-12-1-16-9-19-18z" fill="#8a9a7e" opacity="0.16" />
                        <circle cx="30" cy="36" r="8" fill="#8a9a7e" />
                        <path d="M30 46c-8 0-13 5-13 12v4h26v-4c0-7-5-12-13-12z" fill="#8a9a7e" opacity="0.75" />
                        <circle cx="52" cy="32" r="9" fill="#b96a4b" />
                        <path d="M52 43c-9 0-15 6-15 14v5h30v-5c0-8-6-14-15-14z" fill="#b96a4b" />
                        <circle cx="42" cy="18" r="2.5" fill="#2b3d2f" opacity="0.5" />
                    </svg>
                </div>
                <h3>Komunitas Yoga Roots</h3>
                <p>Terhubung dengan sesama praktisi dalam ruang yang hangat dan suportif.</p>
            </div>
        </div>

        <div class="breath-wrap">
            <div class="breath-circle"></div>
            <span>Tarik napas perlahan.<br>Kamu sudah di tempat yang tepat.</span>
        </div>
    </div>

    <div class="login-card">
        <div class="card-top">
            <button type="button">&larr; Kembali</button>
            <button type="button" id="helpBtn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2 2-2 3.5" stroke-linecap="round" />
                    <circle cx="12" cy="17" r="0.6" fill="currentColor" stroke="none" />
                </svg>
                Bantuan
            </button>
        </div>

        <form method="POST" id="loginForm" action="{{ route('login') }}">
            @csrf

            <h2>Masuk</h2>
            <p class="subtitle">Temukan kelasmu, lanjutkan latihanmu.</p>

            @if ($errors->has('email'))
            <p class="mb-2 text-sm text-danger">The email address or password is incorrect.</p>
            @endif

            <div class="field">
                <label for="email">Alamat Email</label>
                <input name="email" id="email" type="email" placeholder="Email Anda" oninput="toggleBtn()" required>
            </div>

            <div class="field">
                <label for="password">Kata Sandi</label>
                <div class="password-wrap">
                    <input name="password" id="password" type="password" placeholder="Masukkan kata sandi" oninput="toggleBtn()" required>
                    <button type="button" class="eye-btn" id="eyeBtn" aria-label="Tampilkan kata sandi">
                        <svg id="eyeIcon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="forgot-row">
                <a href="#">Lupa kata sandi?</a>
            </div>

            <button type="submit" class="btn-primary" id="lanjutBtn">Lanjutkan</button>

            <div class="divider">atau masuk dengan</div>

            <a href="{{ url('auth/google') }}" class="btn-social">
                <svg width="18" height="18" viewBox="0 0 48 48">
                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.9 32.9 29.4 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z" />
                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.6 16 19 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.6 6.1 29.6 4 24 4 16.3 4 9.7 8.3 6.3 14.7z" />
                    <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.4 35 26.8 36 24 36c-5.3 0-9.8-3.1-11.3-7.5l-6.5 5C9.5 39.6 16.2 44 24 44z" />
                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4.1 5.5l6.3 5.3C39.9 36.5 44 30.9 44 24c0-1.3-.1-2.7-.4-3.5z" />
                </svg>
                Masuk dengan Google
            </a>

            <div class="card-footer">
                <span>Mulai perjalanan wellness bersama <b>YogaRoots</b></span>
            </div>

        </form>

    </div>
</div>

<!-- FAQ Modal -->
<div class="modal-overlay" id="helpModal">
    <div class="modal">
        <div class="modal-header">
            <h2>FAQ & ANSWES</h2>
            <button class="modal-close" id="closeModal">&times;</button>
        </div>
        <div class="modal-body" id="faqList">

            @foreach ($faqs as $faq)
            <div class="faq-item">
                <button class="faq-q">
                    {{ $faq->pertanyaan }}

                    <svg class="chev" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                <div class="faq-a">
                    <p>{{ $faq->jawaban }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@endsection
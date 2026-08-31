@extends('layouts.auth')
@section('title', '404')
@section('content')

<div id="404">

  <svg class="bg-leaf one" viewBox="0 0 120 200" fill="none">
    <path d="M60 5C30 40 15 90 25 140c8 38 35 55 35 55s27-17 35-55c10-50-5-100-35-135z" stroke="#8a9a7e" stroke-width="1.4" fill="none" />
    <path d="M60 10v185" stroke="#8a9a7e" stroke-width="1.2" />
  </svg>
  <svg class="bg-leaf two" viewBox="0 0 120 200" fill="none">
    <path d="M60 5C30 40 15 90 25 140c8 38 35 55 35 55s27-17 35-55c10-50-5-100-35-135z" stroke="#b96a4b" stroke-width="1.4" fill="none" />
    <path d="M60 10v185" stroke="#b96a4b" stroke-width="1.2" />
  </svg>

  <div class="logo-row">
    <div class="logo-mark">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#b96a4b" stroke-width="1.3">
        <path d="M12 21c0-6 0-9-4-13" stroke-linecap="round" />
        <path d="M12 21c0-6 0-9 4-13" stroke-linecap="round" />
        <path d="M12 21c0-8 0-14 0-18" stroke-linecap="round" />
        <path d="M8 8c0-2.5 1.5-4 4-5 2.5 1 4 2.5 4 5" stroke-linecap="round" />
      </svg>
    </div>
    <div class="logo-text">yoga <span class="roots">roots</span></div>
  </div>

  <div class="stage">

    <!-- Illustration: figure in meditation pose beside a wandering path -->
    <svg class="path-illustration" viewBox="0 0 420 220" fill="none">
      <path d="M20 190C90 150 130 210 200 170C270 130 300 190 400 150" stroke="#8a9a7e" stroke-width="1.4" stroke-dasharray="4 7" fill="none" opacity="0.6" />
      <circle cx="20" cy="190" r="4" fill="#b96a4b" opacity="0.5" />
      <circle cx="400" cy="150" r="4" fill="#2b3d2f" opacity="0.35" />
      <g transform="translate(178,60)">
        <ellipse cx="42" cy="128" rx="46" ry="8" fill="#2b3d2f" opacity="0.06" />
        <path d="M0 118c0-20 10-30 22-34-6-8-8-18-3-27 6-11 20-14 29-6 8 7 8 18 2 27 12 3 24 13 24 40" fill="#b96a4b" opacity="0.85" />
        <circle cx="42" cy="34" r="17" fill="#2b3d2f" />
        <path d="M25 34c0-10 8-18 17-18s17 8 17 18" fill="none" />
        <path d="M4 100c-8 6-10 14-8 20M80 100c8 6 10 14 8 20" stroke="#2b3d2f" stroke-width="2" stroke-linecap="round" />
        <path d="M18 108c8 4 16 4 24 0M46 108c8 4 16 4 24 0" stroke="#fff" stroke-width="1.6" stroke-linecap="round" opacity="0.7" />
      </g>
      <g transform="translate(280,45)">
        <path d="M15 0C6 8 2 22 6 34c3 9 10 13 10 13s10-4 12-13c3-12-2-26-13-34z" fill="none" stroke="#8a9a7e" stroke-width="1.4" />
        <text x="8" y="24" font-family="Fraunces, serif" font-size="18" fill="#8a9a7e">?</text>
      </g>
    </svg>

    <p class="eyebrow"><span class="dash"></span>Halaman tidak ditemukan</p>
    <h1>4<em>0</em>4</h1>
    <h2>Sepertinya jalur ini belum kami petakan.</h2>
    <p class="lead">Tarik napas sejenak — halaman yang kamu cari mungkin sudah dipindahkan, berganti nama, atau memang belum pernah ada. Mari kembali ke jalur yang lebih tenang.</p>

    <div class="action-row">
      <a href="/" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 11l9-8 9 8" />
          <path d="M5 10v10h14V10" />
        </svg>
        Kembali ke Beranda
      </a>
      <a href="/kelas" class="btn-secondary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" />
          <path d="M3 10h18" />
          <path d="M8 2v4M16 2v4" />
        </svg>
        Lihat Jadwal Kelas
      </a>
    </div>

    <div class="breath-note">
      <div class="breath-circle"></div>
      <span>Tidak apa tersesat sesekali.<br>Yang penting, kamu tahu ke mana kembali.</span>
    </div>

  </div>

</div>

@endsection
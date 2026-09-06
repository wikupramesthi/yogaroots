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
      <img src="{{ asset('img/logo-yogaroots.png') }}" alt="logo yogaroots">
    </div>
  </div>

  <div class="stage">

    <p class="eyebrow"><span class="dash"></span>Page Not Found</p>
    <h1>4<em>0</em>4</h1>
    <h2>It seems this path hasn’t been mapped yet.</h2>
    <p class="lead">The page you’re looking for may have been moved, renamed, or no longer exists. Take a moment, then let’s get you back on the right path.</p>

    <div class="action-row">
      <a href="{{ route('dashboard.index') }}" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 11l9-8 9 8" />
          <path d="M5 10v10h14V10" />
        </svg>
        Back to Home
      </a>
      <a href="/kelas" class="btn-secondary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" />
          <path d="M3 10h18" />
          <path d="M8 2v4M16 2v4" />
        </svg>
        Explore Class Schedule
      </a>
    </div>

    <div class="breath-note">
      <div class="breath-circle"></div>
      <span>It’s okay to lose your way sometimes.<br>What matters is knowing the way back.</span>
    </div>

  </div>

</div>

@endsection
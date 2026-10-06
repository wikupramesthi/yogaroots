<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="theme-color" content="#4b6b52" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}" />
    <link rel="apple-touch-icon" href="{{ asset('img/icon-192.png') }}" />
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">

    <!-- Style -->
    @stack('before-style')
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/mobile.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    @stack('after-style')
    <!-- /Style -->

</head>

<body>
    <div class="phone">
        <main>
            @yield('content')
        </main>

        <nav class="tabbar d-flex {{ request()->routeIs('checkout.package', 'login', 'class-bookings.scan') ? 'd-none' : '' }}">

            <button type="button"
                class="tab-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('dashboard.index') }}'">
                <span class="ico"><i class="bi bi-house"></i></span>
                <span>{{ __('mobile.home') }}</span>
            </button>

            <button type="button"
                class="tab-item {{ request()->routeIs('packages.member') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('packages.member') }}'">
                <span class="ico"><i class="bi bi-tags"></i></span>
                <span>{{ __('mobile.plans') }}</span>
            </button>

            <button type="button"
                class="tab-item tab-booking {{ request()->routeIs('schedules.index') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('schedules.index') }}'">
                <span class="ico"><i class="bi bi-calendar-plus"></i></span>
                <span>{{ __('mobile.book') }}</span>
            </button>

            <button type="button"
                class="tab-item {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('orders.index') }}'">
                <span class="ico"><i class="bi bi-receipt"></i></span>
                <span>{{ __('mobile.orders') }}</span>
            </button>

            <button type="button"
                class="tab-item {{ request()->routeIs('profile.edit', 'account.*', 'bookings.my', 'memberships.*', 'instruktur.mobile') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('profile.edit') }}'">
                <span class="ico"><i class="bi bi-person-circle"></i></span>
                <span>{{ __('mobile.profile') }}</span>
            </button>

        </nav>
    </div>

    <!-- Script -->
    @stack('before-script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Toast feedback + loading state --}}
    <div id="mobile-toasts" class="position-fixed start-0 end-0 z-3 d-flex flex-column align-items-center px-4"
        style="bottom: calc(92px + env(safe-area-inset-bottom, 0px)); pointer-events:none;">
        @if (session('success'))
            <div class="alert alert-success border-0 py-2 px-3 small w-100 shadow-sm" role="alert">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-0 py-2 px-3 small w-100 shadow-sm" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger border-0 py-2 px-3 small w-100 shadow-sm" role="alert">{{ $errors->first() }}</div>
        @endif
    </div>
    <div id="mobile-page-loader" class="position-fixed top-0 start-0 end-0 bottom-0 d-none"
        style="background: rgba(250, 248, 242, .65); z-index: 1050;">
        <div class="mobile-loader-bar"></div>
        <div class="spinner-border text-sage" role="status" style="margin-top:50vh;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <style>
        #mobile-page-loader:not(.d-none) { display: flex !important; flex-direction: column; align-items: center; }
        #mobile-page-loader .mobile-loader-bar {
            position: absolute; top: 0; left: 0; height: 3px; width: 30%;
            background: var(--sage, #4b6b52); border-radius: 0 3px 3px 0;
            animation: mobile-loader-slide 1s ease-in-out infinite;
        }
        @keyframes mobile-loader-slide {
            0% { left: -30%; } 100% { left: 100%; }
        }
        .tab-item.is-loading, a.is-loading { opacity: .6; pointer-events: none; }
    </style>
    <script>
        (function () {
            var loader = document.getElementById('mobile-page-loader');
            var loaderTimer = null;

            function showPageLoader() {
                if (!loader || !loader.classList.contains('d-none')) return;
                loader.classList.remove('d-none');
            }

            function hidePageLoader() {
                if (!loader) return;
                loader.classList.add('d-none');
                if (loaderTimer) { clearTimeout(loaderTimer); loaderTimer = null; }
            }

            // Safety: jangan kunci layar selamanya kalau navigasi batal/gagal.
            function armSafety() {
                if (loaderTimer) clearTimeout(loaderTimer);
                loaderTimer = setTimeout(hidePageLoader, 8000);
            }

            setTimeout(function () {
                var t = document.getElementById('mobile-toasts');
                if (t) t.innerHTML = '';
            }, 5000);

            // Tiap pindah halaman: tabbar (button onclick), link internal, back.
            document.addEventListener('click', function (e) {
                var el = e.target.closest('button.tab-item, a[href]');
                if (!el || el.classList.contains('is-loading')) return;
                if (el.hasAttribute('data-bs-toggle')) return;
                if (el.getAttribute('data-no-loader') !== null) return;

                // Button tabbar selalu navigasi via onclick -> tampilkan loader.
                if (el.tagName === 'BUTTON') {
                    el.classList.add('is-loading');
                    showPageLoader(); armSafety();
                    return;
                }

                var href = el.getAttribute('href');
                if (!href || href.charAt(0) === '#' || href.indexOf('javascript:') === 0) return;
                if (el.target === '_blank' || el.hasAttribute('download')) return;
                // Hanya navigasi internal (relative) yang dikasih loader.
                if (href.indexOf('http') === 0 && href.indexOf(window.location.origin) !== 0) return;

                el.classList.add('is-loading');
                showPageLoader(); armSafety();
            }, true);

            document.addEventListener('submit', function (e) {
                var form = e.target;
                if (form.tagName !== 'FORM') { return; }
                var btns = form.querySelectorAll('button[type="submit"]');
                btns.forEach(function (b) {
                    if (!b.dataset.loading) {
                        b.dataset.loading = '1';
                        b.disabled = true;
                        b.insertAdjacentHTML('afterbegin', '<span class="spinner-border spinner-border-sm me-1" role="status"></span>');
                    }
                });
                showPageLoader(); armSafety();
            }, true);

            // Balik dari bfcache / back button: pastikan loader hilang.
            window.addEventListener('pageshow', hidePageLoader);

            // PWA: daftarkan service worker (cache aset statis saja).
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function () {
                    navigator.serviceWorker.register("{{ asset('sw.js') }}").catch(function () {});
                });
            }

            // PWA install prompt -> tampilkan tombol di Profile.
            (function () {
                var btn = document.getElementById('pwa-install');
                if (!btn) return;
                window.addEventListener('beforeinstallprompt', function (e) {
                    e.preventDefault();
                    window.__pwaPrompt = e;
                    btn.classList.remove('d-none');
                });
                btn.addEventListener('click', function () {
                    var p = window.__pwaPrompt;
                    if (p) { p.prompt(); window.__pwaPrompt = null; }
                });
            })();
        })();
    </script>

    @stack('after-script')
    <!-- /Script -->

</body>

</html>
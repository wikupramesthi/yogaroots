<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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

        <nav class="tabbar d-flex {{ request()->routeIs('checkout.package', 'login') ? 'd-none' : '' }}">

            <button type="button"
                class="tab-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('dashboard.index') }}'">
                <span class="ico"><i class="bi bi-house"></i></span>
                <span>Home</span>
            </button>

            <button type="button"
                class="tab-item {{ request()->routeIs('packages.member') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('packages.member') }}'">
                <span class="ico"><i class="bi bi-tags"></i></span>
                <span>Plans</span>
            </button>

            <button type="button"
                class="tab-item tab-booking {{ request()->routeIs('schedules.index') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('schedules.index') }}'">
                <span class="ico"><i class="bi bi-calendar-plus"></i></span>
                <span>Book</span>
            </button>

            <button type="button"
                class="tab-item {{ request()->routeIs('instruktur.mobile') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('instruktur.mobile') }}'">
                <span class="ico"><i class="bi bi-easel2"></i></span>
                <span>Teacher</span>
            </button>

            <button type="button"
                class="tab-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                onclick="window.location.href='{{ route('profile.edit') }}'">
                <span class="ico"><i class="bi bi-person-circle"></i></span>
                <span>Profile</span>
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
        <div class="spinner-border text-sage" role="status" style="margin-top:50vh;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <script>
        (function () {
            setTimeout(function () {
                var t = document.getElementById('mobile-toasts');
                if (t) t.innerHTML = '';
            }, 5000);

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
                var loader = document.getElementById('mobile-page-loader');
                if (loader) { loader.classList.remove('d-none'); loader.classList.add('d-flex', 'flex-column', 'align-items-center'); }
            }, true);
        })();
    </script>

    @stack('after-script')
    <!-- /Script -->

</body>

</html>
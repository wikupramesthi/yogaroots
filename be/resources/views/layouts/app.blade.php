<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">

    <!-- Style -->
    @stack('before-style')
    {{-- @include('components.includes.style') --}}

    <link rel="stylesheet" href="{{ asset('dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/iconly.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-modern.css') }}?v={{ \Illuminate\Support\Facades\File::exists(public_path('css/admin-modern.css')) ? filemtime(public_path('css/admin-modern.css')) : '1' }}" />

    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    @stack('after-style')
    <!-- /Style -->

</head>

<body>
    <div class="min-height-300 bg-dark position-absolute w-100"></div>
    <div class="app-loader" id="app-loader">
        <img src="{{ asset('img/logo-yogaroots.png') }}" alt="YogaRoots" class="app-loader__logo app-loader__logo--light">
        <img src="{{ asset('img/logo-white.png') }}" alt="YogaRoots" class="app-loader__logo app-loader__logo--dark">
        <div class="app-loader__spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="app-loader__text">Loading page&hellip;</span>
    </div>
    <div id="app">
        <x-menu />

        <div id="main" class='layout-navbar navbar-fixed'>
            <x-web.header />

            <div id="main-content">
                <x-validation-errors />
                <div class="page-heading">
                    <div class="page-title">
                        @yield('breadcrumb')
                    </div>
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer>
                <div class="footer clearfix mb-0">
                    <div class="argon-footer d-flex flex-wrap justify-content-center align-items-center gap-2 text-center">
                        <span>&copy; <script>
                                document.write(new Date().getFullYear())
                            </script> YogaRoots.</span>
                        <span class="argon-footer-dot" aria-hidden="true"></span>
                        <span>All rights reserved</span>
                    </div>
                </div>
            </footer>
            <!--/Footer -->

            <!-- WhatsApp Floating Button -->
            <a href="https://api.whatsapp.com/send/?phone=6281321221270&text=Hi%2C%20I%20found%20you%20through%20your%20website%20and%20would%20like%20more%20information%20about%20your%20classes.%20Thank%20you%21&app_absent=0"
                target="_blank"
                rel="noopener noreferrer"
                aria-label="Chat on WhatsApp"
                class="whatsapp-float">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="28"
                    height="28"
                    fill="currentColor"
                    viewBox="0 0 16 16">
                    <path d="M13.601 2.326A7.85 7.85 0 0 0 8.016 0C3.595 0 0 3.594 0 8.014c0 1.412.369 2.791 1.071 4.004L0 16l4.076-1.067a7.96 7.96 0 0 0 3.94 1.003h.003c4.42 0 8.015-3.594 8.015-8.014a7.9 7.9 0 0 0-2.433-5.596zM8.016 14.613h-.002a6.62 6.62 0 0 1-3.376-.924l-.242-.144-2.42.634.646-2.357-.158-.242a6.62 6.62 0 0 1-1.015-3.566c0-3.662 2.98-6.64 6.646-6.64a6.6 6.6 0 0 1 4.706 1.95 6.6 6.6 0 0 1 1.948 4.71c-.002 3.662-2.982 6.64-6.643 6.64zm3.646-4.978c-.2-.1-1.182-.583-1.365-.65-.183-.067-.316-.1-.45.1-.133.2-.516.65-.633.783-.116.133-.233.15-.433.05-.2-.1-.85-.313-1.62-.998-.599-.534-1.003-1.194-1.12-1.394-.116-.2-.012-.308.088-.408.09-.09.2-.233.3-.35.1-.116.133-.2.2-.333.067-.133.033-.25-.017-.35-.05-.1-.45-1.083-.616-1.483-.163-.39-.33-.337-.45-.343h-.383c-.133 0-.35.05-.533.25-.183.2-.7.683-.7 1.666s.716 1.932.816 2.065c.1.133 1.41 2.153 3.417 3.018.478.207.851.331 1.142.423.48.153.917.132 1.262.08.385-.058 1.182-.483 1.349-.95.166-.466.166-.866.116-.95-.05-.083-.183-.133-.383-.233z" />
                </svg>
            </a>

        </div>
    </div>

    {{-- Global command palette (Ctrl+K): at <body> level so it sits above all stacking contexts --}}
    <div class="modal fade" id="globalSearchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog gs-modal-dialog">
            <div class="modal-content gs-palette" role="dialog" aria-modal="true" aria-label="Global search">
                <div class="gs-input-row">
                    <i class="bi bi-search gs-input-icon"></i>
                    <input type="text" id="global-search-input" class="gs-input"
                        placeholder="Search articles, events, classes, packages, studios, pages, users... (min. 2 characters)"
                        autocomplete="off">
                    <button type="button" id="global-search-close" class="gs-esc" aria-label="Close">ESC</button>
                </div>
                <div id="global-search-results" class="gs-results">
                    <p class="gs-hint">Type to search across all modules.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    @stack('before-script')
    {{-- @include('components.includes.script') --}}
    <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>

    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dist/assets/static/js/pages/datatables.js') }}"></script>

    <script src="{{ asset('dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

    @stack('after-script')
    <!-- /Script -->

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            // Legacy IDs (existing YogaRoots pages) — do not remove so the legacy editor keeps working
            if ($('#deskripsi').length && !$('#deskripsi').hasClass('summernote-initialized')) {
                $('#deskripsi').addClass('summernote-initialized').summernote();
            }
            if ($('#latar_belakang').length && !$('#latar_belakang').hasClass('summernote-initialized')) {
                $('#latar_belakang').addClass('summernote-initialized').summernote();
            }
            if ($('#hasil').length && !$('#hasil').hasClass('summernote-initialized')) {
                $('#hasil').addClass('summernote-initialized').summernote();
            }
            if ($('#event').length && !$('#event').hasClass('summernote-initialized')) {
                $('#event').addClass('summernote-initialized').summernote({
                    height: 200
                });
            }

            // Generic DBMSDA-style setup for .summernote textareas (including inside modals)
            function initSummernote($container) {
                $container.find('.summernote').each(function() {
                    if (!$(this).hasClass('summernote-initialized')) {
                        $(this).addClass('summernote-initialized').summernote({
                            height: 200,
                            toolbar: [
                                ['style', ['style']],
                                ['font', ['bold', 'underline', 'clear']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['table', ['table']],
                                ['insert', ['link', 'picture', 'video']],
                                ['view', ['fullscreen', 'codeview', 'help']]
                            ]
                        });
                    }
                });
            }

            initSummernote($(document));

            $(document).on('shown.bs.modal', '.modal', function() {
                initSummernote($(this));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#specializations').select2({
                placeholder: 'Select specialization',
                width: '100%',
                closeOnSelect: false
            });
        });
    </script>

    <script>
        (function() {
            var loader = document.getElementById('app-loader');

            function hideLoader() {
                if (!loader || loader.classList.contains('is-hidden')) return;
                loader.classList.add('is-hidden');

                window.setTimeout(function() {
                    if (loader && loader.parentNode) {
                        loader.parentNode.removeChild(loader);
                    }
                }, 400);
            }

            if (document.readyState === 'complete') {
                hideLoader();
            } else {
                window.addEventListener('load', hideLoader);
            }

            /* Safety net: don't let the loader block the page forever. */
            window.setTimeout(hideLoader, 8000);
        })();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    @auth
    <script>
        (function() {
            // Auto-logout after 30 minutes without activity (DBMSDA-style).
            // 2 minutes before expiry show the choice: Stay signed in / Logout.
            const INACTIVE_TIMEOUT_MIN = {{ (int) config('session.inactive_timeout', 30) }};
            const WARNING_BEFORE_MIN = 2;
            const INACTIVE_MS = INACTIVE_TIMEOUT_MIN * 60 * 1000;
            const WARNING_MS = WARNING_BEFORE_MIN * 60 * 1000;
            const TIMEOUT_MS = INACTIVE_MS - WARNING_MS;
            const idleLimit = TIMEOUT_MS > 5000 ? TIMEOUT_MS : 5000;

            let idleTimer = null;
            let warningShown = false;
            let countdownInterval = null;
            let alreadyLoggingOut = false;

            function getCsrf() {
                const meta = document.querySelector('meta[name="csrf-token"]');
                return meta ? meta.getAttribute('content') : '';
            }

            function doLogout() {
                if (alreadyLoggingOut) return;
                alreadyLoggingOut = true;
                if (countdownInterval) clearInterval(countdownInterval);
                const token = getCsrf();
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('logout') }}";
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                input.value = token;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }

            function keepAlive() {
                const token = getCsrf();
                return fetch("{{ route('keep-alive') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                }).then((res) => {
                    // 419 (CSRF) / 401 (session habis) dianggap gagal -> logout tegas.
                    if (!res.ok) return false;
                    return res.json().then((data) => data && data.ok === true).catch(() => false);
                }).catch(() => false);
            }

            function showWarning() {
                if (warningShown) return;
                warningShown = true;
                let remaining = WARNING_BEFORE_MIN * 60;

                const updateText = () => {
                    const m = Math.floor(remaining / 60);
                    const s = String(remaining % 60).padStart(2, '0');
                    const html = `Your session will expire in <b>${m}:${s}</b> due to inactivity.<br>Click <b>Stay signed in</b> to continue.`;
                    const container = document.querySelector('.swal2-html-container');
                    if (container) container.innerHTML = html;
                };

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Session expiring soon',
                        html: `Your session will expire in <b>${WARNING_BEFORE_MIN}:00</b> due to inactivity.<br>Click <b>Stay signed in</b> to continue.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Stay signed in',
                        cancelButtonText: 'Logout',
                        confirmButtonColor: '#2f7d4f',
                        cancelButtonColor: '#d33',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            countdownInterval = setInterval(() => {
                                remaining--;
                                if (remaining <= 0) {
                                    clearInterval(countdownInterval);
                                    countdownInterval = null;
                                    if (typeof Swal !== 'undefined') Swal.close();
                                    doLogout();
                                } else {
                                    updateText();
                                }
                            }, 1000);
                        },
                        willClose: () => {
                            if (countdownInterval) clearInterval(countdownInterval);
                        }
                    }).then((result) => {
                        // Klik "Stay signed in": refresh server dulu, reset timer
                        // HANYA jika server jawab ok. Kalau gagal (401/419) -> logout.
                        if (result.isConfirmed) {
                            if (countdownInterval) {
                                clearInterval(countdownInterval);
                                countdownInterval = null;
                            }
                            keepAlive().then((alive) => {
                                if (alive) {
                                    warningShown = false;
                                    alreadyLoggingOut = false;
                                    resetTimer();
                                } else {
                                    doLogout();
                                }
                            });
                        } else {
                            // "Logout" / countdown habis / dismiss lain -> logout tegas.
                            // Jangan resetTimer tanpa keepAlive agar client & server tidak selisih.
                            doLogout();
                        }
                    });
                } else {
                    const ok = confirm(`Your session will expire in ${WARNING_BEFORE_MIN} minutes due to inactivity. Click OK to stay signed in.`);
                    if (ok) {
                        keepAlive().then((alive) => {
                            if (alive) {
                                warningShown = false;
                                resetTimer();
                            } else {
                                doLogout();
                            }
                        });
                    } else {
                        doLogout();
                    }
                }
            }

            function resetTimer() {
                if (idleTimer) clearTimeout(idleTimer);
                if (countdownInterval) clearInterval(countdownInterval);
                warningShown = false;
                idleTimer = setTimeout(showWarning, idleLimit);
            }

            let throttle = false;
            function onActivity() {
                if (warningShown) return;
                if (throttle) return;
                throttle = true;
                setTimeout(() => throttle = false, 1000);
                resetTimer();
            }

            ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'].forEach(evt => {
                document.addEventListener(evt, onActivity, { passive: true });
            });

            resetTimer();
        })();
    </script>
    @endauth

    <script>
        $(document).on("click", ".mark-as-read", function(e) {            e.preventDefault();

            let id = $(this).data("id");
            let $item = $(this).closest(".notification-item");

            $.ajax({
                url: "{{ url('/notifications') }}/" + id + "/read",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        // remove DBMSDA-style unread highlight
                        $item.removeClass("unread");
                        $item.find(".notif-dot").addClass("read");

                        // update badge count
                        let count = parseInt($("#notif-count").text()) - 1;
                        if (count > 0) {
                            $("#notif-count").text(count);
                        } else {
                            $("#notif-count").remove();
                        }
                    }
                }
            });
        });
    </script>


</body>

</html>

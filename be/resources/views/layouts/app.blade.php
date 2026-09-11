<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">

    <!-- Style -->
    @stack('before-style')
    {{-- @include('components.includes.style') --}}

    <link rel="stylesheet" href="{{ asset('dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/iconly.css') }}" />

    <link
        href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    @stack('after-style')
    <!-- /Style -->

</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-white">
        <div class="spinner-border" role="status" id="loading">
            <span class="visually-hidden">Loading...</span>
        </div>
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
                <div class="footer clearfix mb-0 text-center">
                    <div class="float-center">
                        <p>
                            <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; Yoga Roots. all rights reserved
                        </p>
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
            $('#deskripsi').summernote();
            $('#latar_belakang').summernote();
            $('#hasil').summernote();
            $('#event').summernote({
                height: 200
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#specializations').select2({
                placeholder: 'Pilih specialization',
                width: '100%',
                closeOnSelect: false
            });
        });
    </script>

    <script>
        var loading = document.getElementById('loading');
        var contents = document.getElementById('contents');
        window.addEventListener('load', function() {
            loading.classList.add('d-none');
            loading.parentNode.classList.replace('vh-100', 'd-none');
            contents.classList.remove('d-none');
        });

        const reload = document.querySelector('#reload');
        reload.addEventListener('click', () => {
            loading.classList.remove('d-none');
            loading.parentNode.classList.replace('d-none', 'vh-100');
            contents.classList.add('d-none');
            window.setTimeout(() => {
                window.location.reload(true);
            }, 3000);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <script>
        $(document).on("click", ".mark-as-read", function(e) {
            e.preventDefault();

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
                        // hapus highlight bg-light
                        $item.removeClass("bg-light");

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
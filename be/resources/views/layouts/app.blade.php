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
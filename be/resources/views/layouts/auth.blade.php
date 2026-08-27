<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="title" content="Sekolah Disabilitas Terpadu Kota Bekasi | Pendidikan Inklusif & Berkualitas">
    <meta name="description"
        content="Sekolah Disabilitas Terpadu Kota Bekasi menyediakan layanan pendidikan inklusif bagi anak berkebutuhan khusus (ABK) dengan pendekatan holistik, guru berpengalaman, serta fasilitas ramah disabilitas untuk mendukung perkembangan akademik dan keterampilan hidup.">
    <meta name="keywords"
        content="Sekolah Disabilitas Bekasi, Sekolah Inklusif Bekasi, Sekolah ABK Bekasi, Pendidikan Anak Berkebutuhan Khusus, Sekolah Ramah Disabilitas, SLB Bekasi">
    <meta name="author" content="Dinas Pendidikan Kota Bekasi">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Sekolah Disabilitas Terpadu Kota Bekasi | Pendidikan Inklusif & Berkualitas">
    <meta property="og:description"
        content="Sekolah inklusif di Bekasi yang mendukung anak berkebutuhan khusus dengan fasilitas ramah disabilitas, guru profesional, dan metode pembelajaran holistik.">
    <meta property="og:image" content="{{ asset('img/seamless-pattern3.png') }}">

    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/auth.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>
    <div id="auth">

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'bi bi-eye';
            }
        }

        // Handle Loading State on Submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            const loginText = submitBtn.querySelector('.login-text');
            const loadingText = submitBtn.querySelector('.loading-text');

            loginText.classList.add('d-none');
            loadingText.classList.remove('d-none');
            submitBtn.disabled = true;
        });

        // Add interactive effects on input focus/blur
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Auto-show toast if exists
        document.querySelectorAll('.toast').forEach(toastEl => {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>


</body>

</html>

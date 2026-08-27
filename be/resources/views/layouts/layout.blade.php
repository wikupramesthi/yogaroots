<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist&display=swap" rel="stylesheet">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WTJ09KDXS5"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-WTJ09KDXS5');
    </script>


    @vite(['resources/css/app.css'])

</head>

<body class="min-h-screen bg-white selection:bg-primary/10 selection:text-primary dark:bg-gray-900">
    <x-partial.header />
    @yield('content')
    <x-partial.footer />

    @stack('before-script')
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://website-widgets.pages.dev/dist/sienna.min.js" defer></script>
    <script src="{{ asset('/frontend/js/particles.js') }}"></script>
    <script src="{{ asset('/frontend/js/app.js') }}"></script>
    @stack('after-script')

</body>

</html>

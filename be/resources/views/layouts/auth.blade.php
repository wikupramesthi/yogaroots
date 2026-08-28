<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <meta name="title" content="YogaRoots | Studio Wellness, Yoga & Mindfulness">
    <meta name="description"
        content="YogaRoots adalah studio wellness di Jakarta yang menghadirkan ruang untuk yoga, meditasi, mindfulness, dan praktik kebugaran untuk membantu tubuh dan pikiran lebih seimbang.">
    <meta name="keywords"
        content="YogaRoots Jakarta, studio yoga Jakarta, yoga Jakarta, kelas yoga Jakarta, mindfulness Jakarta, meditasi Jakarta, wellness Jakarta, studio wellness Jakarta">
    <meta name="author" content="YogaRoots">
    <meta name="robots" content="index, follow">

    <meta property="og:title"
        content="YogaRoots | Studio Wellness, Yoga & Mindfulness">
    <meta property="og:description"
        content="Ruang wellness di Jakarta untuk yoga, meditasi, mindfulness, dan praktik kebugaran yang mendukung keseimbangan tubuh dan pikiran.">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="YogaRoots">
    <meta property="og:image" content="{{ asset('img/seamless-pattern3.png') }}">

    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/auth.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Jost:wght@400;500;600&display=swap" rel="stylesheet">

</head>

<body>

    <div id="leaf">
        <svg class="bg-leaf one" viewBox="0 0 120 200" fill="none">
            <path d="M60 5C30 40 15 90 25 140c8 38 35 55 35 55s27-17 35-55c10-50-5-100-35-135z" stroke="#8a9a7e" stroke-width="1.4" fill="none" />
            <path d="M60 10v185" stroke="#8a9a7e" stroke-width="1.2" />
        </svg>
        <svg class="bg-leaf two" viewBox="0 0 120 200" fill="none">
            <path d="M60 5C30 40 15 90 25 140c8 38 35 55 35 55s27-17 35-55c10-50-5-100-35-135z" stroke="#b96a4b" stroke-width="1.4" fill="none" />
            <path d="M60 10v185" stroke="#b96a4b" stroke-width="1.2" />
        </svg>
    </div>

    <div id="auth">

        @yield('content')

    </div>

    <script>
        function toggleBtn() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const btn = document.getElementById('lanjutBtn');
            const ok = email.length > 3 && email.includes('@') && email.includes('.') && password.length >= 6;
            btn.classList.toggle('active', ok);
        }

        const eyeBtn = document.getElementById('eyeBtn');
        const eyeIcon = document.getElementById('eyeIcon');
        const passwordInput = document.getElementById('password');
        eyeBtn.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeBtn.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
            eyeIcon.innerHTML = isHidden ?
                '<path d="M3 3l18 18" /><path d="M10.6 10.6a3 3 0 0 0 4.24 4.24"/><path d="M6.5 6.6C3.9 8.3 2 12 2 12s3.5 7 10 7c1.9 0 3.5-.5 4.9-1.3"/><path d="M17.9 17.9C20.4 16.1 22 12 22 12s-3.5-7-10-7c-.6 0-1.2.05-1.8.14"/>' :
                '<path d="M1.5 12S5 5 12 5s10.5 7 10.5 7-3.5 7-10.5 7S1.5 12 1.5 12z"/><circle cx="12" cy="12" r="3"/>';
        });

        const modal = document.getElementById('helpModal');
        document.getElementById('helpBtn').addEventListener('click', () => modal.classList.add('open'));
        document.getElementById('closeModal').addEventListener('click', () => modal.classList.remove('open'));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.remove('open');
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') modal.classList.remove('open');
        });

        document.querySelectorAll('.faq-q').forEach(q => {
            q.addEventListener('click', () => {
                q.parentElement.classList.toggle('open');
            });
        });
    </script>

</body>

</html>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Aset ULBI')</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/ulbi/theme.css') }}">
</head>
<body>
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <header class="site-header">
        <div class="container-xl site-header-inner">
            <a class="site-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/ulbi/logo-ulbi.png') }}" width="738" height="270"
                    alt="Universitas Logistik &amp; Bisnis Internasional">
                <span>Sistem Aset Kampus</span>
            </a>

            <nav aria-label="Navigasi utama">
                <a class="back-link" href="{{ route('rooms.index') }}"
                    @if (request()->routeIs('rooms.index')) aria-current="page" @endif>Katalog ruangan</a>
            </nav>
        </div>
    </header>

    <main id="konten" tabindex="-1">
        @yield('content')
    </main>
</body>
</html>

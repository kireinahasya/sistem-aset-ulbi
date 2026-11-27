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

    <header class="site-header" id="top">
        <div class="container-xl site-header-inner">
            <a class="site-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/ulbi/logo-ulbi.png') }}" width="738" height="270"
                    alt="Universitas Logistik &amp; Bisnis Internasional">
                <span>Sistem Aset Kampus</span>
            </a>

            <button class="nav-toggle" type="button" aria-controls="primary-nav" aria-expanded="false"
                aria-label="Buka menu navigasi">
                <span class="nav-toggle-box" aria-hidden="true"><span></span><span></span><span></span></span>
                <span class="nav-toggle-label">Menu</span>
            </button>

            <nav id="primary-nav" class="site-nav" aria-label="Navigasi utama">
                <a class="nav-link" href="{{ route('rooms.index') }}"
                    @if (request()->routeIs('rooms.index')) aria-current="page" @endif>Katalog ruangan</a>
                <a class="nav-link" href="{{ route('equipment.index') }}"
                    @if (request()->routeIs('equipment.index')) aria-current="page" @endif>Sarana tambahan</a>
                <a class="nav-link" href="{{ route('borrowings.create') }}"
                    @if (request()->routeIs('borrowings.create')) aria-current="page" @endif>Peminjaman</a>
                <span class="nav-divider" aria-hidden="true"></span>
                <a class="nav-link nav-link-strong" href="{{ route('login') }}"
                    @if (request()->routeIs('login')) aria-current="page" @endif>Masuk</a>
                <a class="btn btn-primary nav-cta" href="{{ route('register') }}"
                    @if (request()->routeIs('register')) aria-current="page" @endif>Daftar</a>
            </nav>
        </div>
    </header>

    <main id="konten" tabindex="-1">
        @yield('content')
    </main>
    <script src="{{ asset('assets/ulbi/nav.js') }}" defer></script>
    @stack('scripts')
</body>
</html>

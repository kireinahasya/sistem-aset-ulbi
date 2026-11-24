@extends('layouts.app')

@section('content')
    <div class="container-xl auth-page">
        <div class="auth-layout">
            <aside class="auth-intro">
                <img class="campus-photo" src="{{ asset('assets/ulbi/gedung-ulbi.webp') }}"
                    width="800" height="454" alt="Gedung Universitas Logistik &amp; Bisnis Internasional">
                <h2>Peminjaman aset kampus dalam satu tempat</h2>
                <p>Temukan ruang sesuai kebutuhan, pilih sarana tambahan, dan pantau pengajuanmu.</p>
                <a class="back-link" href="{{ route('home') }}">Lihat ketersediaan ruangan</a>
            </aside>
            <section class="availability-panel auth-panel" aria-labelledby="judul-akun">
                <div class="auth-heading">
                    <h1 id="judul-akun">@yield('heading')</h1>
                    <span class="demo-label">Prototipe</span>
                </div>
                @yield('form')
                <noscript><p class="search-errors">Aktifkan JavaScript untuk mencoba formulir demo ini.</p></noscript>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/ulbi/auth-demo.js') }}" defer></script>
@endpush

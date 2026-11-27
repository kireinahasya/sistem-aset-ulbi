@extends('layouts.app')

@section('content')
    <div class="auth-page auth-standalone auth-bg"
        style="background-image: url('{{ asset('assets/ulbi/gedung-ulbi.webp') }}');">
        <div class="container-xl auth-inner">
            <div class="auth-layout">
                <section class="availability-panel auth-panel" aria-labelledby="judul-akun">
                    <div class="auth-heading">
                        <h1 id="judul-akun">@yield('heading')</h1>
                    </div>
                    @yield('form')
                    <noscript><p class="search-errors">Aktifkan JavaScript agar formulir dapat digunakan.</p></noscript>
                </section>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/ulbi/auth.js') }}" defer></script>
@endpush

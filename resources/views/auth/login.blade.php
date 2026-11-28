@extends('auth.layout')

@section('title', 'Masuk | Sistem Aset ULBI')
@section('heading', 'Masuk ke akun')

@section('form')
    <form class="auth-form" data-auth-form="login" method="post" action="{{ route('login') }}" novalidate>
        @csrf
        <div>
            <label class="form-label" for="email">Email</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
                value="{{ old('email') }}" autocomplete="username" inputmode="email" required
                aria-describedby="email-error" aria-invalid="@error('email') true @else false @enderror">
            <span class="auth-error" id="email-error" data-error-for="email">@error('email') {{ $message }} @enderror</span>
        </div>
        <div>
            <label class="form-label" for="password">Kata sandi</label>
            <div class="auth-password">
                <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                    type="password" autocomplete="current-password" required aria-describedby="password-error">
                <button type="button" data-toggle-password="password" aria-controls="password"
                    aria-pressed="false">Tampilkan</button>
            </div>
            <span class="auth-error" id="password-error" data-error-for="password">@error('password') {{ $message }} @enderror</span>
        </div>
        <div class="auth-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
            <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
        </div>
        <a class="back-link auth-forgot" href="{{ route('password.request') }}">Lupa kata sandi?</a>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Masuk</button>
    </form>

    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
        <a class="back-link" href="{{ route('home') }}">Kembali ke beranda</a>
    </div>
    <p class="auth-footer">Belum punya akun mahasiswa? <a href="{{ route('register') }}">Daftar akun</a></p>
@endsection

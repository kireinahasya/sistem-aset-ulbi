@extends('auth.layout')

@section('title', 'Masuk | Sistem Aset ULBI')
@section('heading', 'Masuk ke akun')

@section('form')
    <p class="auth-description">Masuk menggunakan email dan kata sandi sesuai peran akun Anda.</p>
    <div class="auth-role-picker" role="group" aria-label="Peran akun">
        <button type="button" data-role="peminjam" aria-pressed="true">Peminjam</button>
        <button type="button" data-role="admin" aria-pressed="false">Admin Logistik</button>
    </div>

    <form class="auth-form" data-auth-form="login" method="post" action="{{ route('login') }}" novalidate>
        @csrf
        <div>
            <label class="form-label" for="email">Email</label>
            <input class="form-control" id="email" name="email" type="email" autocomplete="username"
                required aria-describedby="email-error">
            <span class="auth-error" id="email-error" data-error-for="email"></span>
        </div>
        <div>
            <label class="form-label" for="password">Kata sandi</label>
            <div class="auth-password">
                <input class="form-control" id="password" name="password" type="password"
                    autocomplete="current-password" required aria-describedby="password-error">
                <button type="button" data-toggle-password="password" aria-controls="password" aria-pressed="false">Tampilkan</button>
            </div>
            <span class="auth-error" id="password-error" data-error-for="password"></span>
        </div>
        <a class="back-link auth-forgot" href="{{ route('password.request') }}">Lupa kata sandi?</a>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Masuk</button>
    </form>

    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
        <a class="back-link" href="{{ route('home') }}">Kembali ke beranda</a>
    </div>
    <p class="auth-footer">Belum punya akun Peminjam? <a href="{{ route('register') }}">Daftar akun</a></p>
@endsection

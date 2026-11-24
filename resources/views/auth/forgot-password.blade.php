@extends('auth.layout')

@section('title', 'Lupa kata sandi | Sistem Aset ULBI')
@section('heading', 'Lupa kata sandi')

@section('form')
    <p class="auth-description">Masukkan email yang terdaftar pada akun Anda.</p>
    <form class="auth-form" data-auth-form="forgot" method="post" action="{{ route('password.request') }}" novalidate>
        @csrf
        <div>
            <label class="form-label" for="email">Email akun</label>
            <input class="form-control" id="email" name="email" type="email" autocomplete="email" required aria-describedby="email-error">
            <span class="auth-error" id="email-error" data-error-for="email"></span>
        </div>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Kirim tautan pemulihan</button>
    </form>
    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
    </div>
    <a class="back-link auth-footer" href="{{ route('login') }}">Kembali ke halaman masuk</a>
@endsection

@extends('auth.layout')

@section('title', 'Lupa kata sandi | Sistem Aset ULBI')
@section('heading', 'Lupa kata sandi')

@section('form')
    <p class="auth-description">Masukkan email akunmu untuk mencoba alur pemulihan kata sandi.</p>
    <form class="auth-form" data-auth-form="forgot" method="post" action="{{ route('password.request') }}" novalidate>
        @csrf
        <div>
            <label class="form-label" for="email">Email akun</label>
            <input class="form-control" id="email" name="email" type="email" autocomplete="email" required aria-describedby="email-error">
            <span class="auth-error" id="email-error" data-error-for="email"></span>
        </div>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Coba pemulihan</button>
    </form>
    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
    </div>
    <a class="back-link auth-footer" href="{{ route('login') }}">Kembali ke halaman masuk</a>
    <p class="auth-caption">Pengiriman tautan pemulihan melalui email akan tersedia pada tahap backend.</p>
@endsection

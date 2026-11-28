@extends('auth.layout')

@section('title', 'Lupa kata sandi | Sistem Aset ULBI')
@section('heading', 'Lupa kata sandi')

@section('form')
    <p class="auth-description">
        Masukkan <strong>email terdaftar</strong> pada akun Anda. Kami kirimkan
        <strong>tautan pemulihan</strong> untuk membuat kata sandi baru ke email tersebut.
    </p>
    <form class="auth-form" data-auth-form="forgot" method="post" action="{{ route('password.request') }}" novalidate>
        @csrf
        <div>
            <label class="form-label" for="email">Email akun</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
                value="{{ old('email') }}" autocomplete="email" inputmode="email" required aria-describedby="email-error">
            <span class="auth-error" id="email-error" data-error-for="email">@error('email') {{ $message }} @enderror</span>
        </div>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Kirim tautan pemulihan</button>
    </form>
    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
    </div>
    <a class="back-link auth-footer" href="{{ route('login') }}">Kembali ke halaman masuk</a>
@endsection

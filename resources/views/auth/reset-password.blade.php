@extends('auth.layout')

@section('title', 'Atur ulang kata sandi | Sistem Aset ULBI')
@section('heading', 'Atur ulang kata sandi')

@section('form')
    <p class="auth-description">
        Buat <strong>kata sandi baru</strong> untuk akun Anda. Tautan ini hanya berlaku
        untuk waktu terbatas dan sekali pakai.
    </p>
    <form class="auth-form" data-auth-form="reset" method="post" action="{{ route('password.reset') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ request('token') }}">
        <div>
            <label class="form-label" for="email">Email akun</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
                value="{{ old('email', request('email')) }}" autocomplete="email" inputmode="email" required
                aria-describedby="email-error">
            <span class="auth-error" id="email-error" data-error-for="email">@error('email') {{ $message }} @enderror</span>
        </div>
        <div>
            <label class="form-label" for="password">Kata sandi baru</label>
            <div class="auth-password">
                <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                    type="password" autocomplete="new-password" minlength="8" required
                    aria-describedby="password-help password-error">
                <button type="button" data-toggle-password="password" aria-controls="password" aria-pressed="false">Tampilkan</button>
            </div>
            <p class="auth-caption" id="password-help">Gunakan minimal 8 karakter.</p>
            <span class="auth-error" id="password-error" data-error-for="password">@error('password') {{ $message }} @enderror</span>
        </div>
        <div>
            <label class="form-label" for="password_confirmation">Konfirmasi kata sandi baru</label>
            <div class="auth-password">
                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password" minlength="8" required aria-describedby="password_confirmation-error">
                <button type="button" data-toggle-password="password_confirmation" aria-controls="password_confirmation"
                    aria-pressed="false">Tampilkan</button>
            </div>
            <span class="auth-error" id="password_confirmation-error" data-error-for="password_confirmation"></span>
        </div>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Simpan kata sandi baru</button>
    </form>
    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
        <a class="back-link" href="{{ route('login') }}">Ke halaman masuk</a>
    </div>
    <a class="back-link auth-footer" href="{{ route('login') }}">Kembali ke halaman masuk</a>
@endsection

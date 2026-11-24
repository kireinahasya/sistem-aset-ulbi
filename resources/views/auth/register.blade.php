@extends('auth.layout')

@section('title', 'Daftar akun | Sistem Aset ULBI')
@section('heading', 'Daftar akun Peminjam')

@section('form')
    <p class="auth-description">Akun Peminjam ditujukan untuk mahasiswa, dosen, dan staf ULBI.</p>
    <form class="auth-form" data-auth-form="register" method="post" action="{{ route('register') }}" novalidate>
        @csrf
        <p class="search-errors" data-form-error role="alert" hidden></p>
        <div>
            <label class="form-label" for="name">Nama lengkap</label>
            <input class="form-control" id="name" name="name" autocomplete="name" required aria-describedby="name-error">
            <span class="auth-error" id="name-error" data-error-for="name"></span>
        </div>
        <div class="auth-field-pair">
            <div>
                <label class="form-label" for="user_type">Jenis pengguna</label>
                <select class="form-select" id="user_type" name="user_type" required aria-describedby="user_type-error">
                    <option value="">Pilih jenis pengguna</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                    <option value="staf">Staf</option>
                </select>
                <span class="auth-error" id="user_type-error" data-error-for="user_type"></span>
            </div>
            <div>
                <label class="form-label" for="campus_id" data-identity-label>Nomor identitas kampus</label>
                <input class="form-control" id="campus_id" name="campus_id" required aria-describedby="campus_id-error">
                <span class="auth-error" id="campus_id-error" data-error-for="campus_id"></span>
            </div>
        </div>
        <div>
            <label class="form-label" for="unit">Program studi atau unit kerja</label>
            <input class="form-control" id="unit" name="unit" required aria-describedby="unit-error">
            <span class="auth-error" id="unit-error" data-error-for="unit"></span>
        </div>
        <div>
            <label class="form-label" for="email">Email aktif</label>
            <input class="form-control" id="email" name="email" type="email" autocomplete="email" required aria-describedby="email-error">
            <span class="auth-error" id="email-error" data-error-for="email"></span>
        </div>
        <div>
            <label class="form-label" for="password">Kata sandi</label>
            <div class="auth-password">
                <input class="form-control" id="password" name="password" type="password" autocomplete="new-password"
                    minlength="8" required aria-describedby="password-help password-error">
                <button type="button" data-toggle-password="password" aria-controls="password" aria-pressed="false">Tampilkan</button>
            </div>
            <p class="auth-caption" id="password-help">Gunakan minimal 8 karakter untuk mencoba formulir.</p>
            <span class="auth-error" id="password-error" data-error-for="password"></span>
        </div>
        <div>
            <label class="form-label" for="password_confirmation">Konfirmasi kata sandi</label>
            <div class="auth-password">
                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password" required aria-describedby="password_confirmation-error">
                <button type="button" data-toggle-password="password_confirmation" aria-controls="password_confirmation"
                    aria-pressed="false">Tampilkan</button>
            </div>
            <span class="auth-error" id="password_confirmation-error" data-error-for="password_confirmation"></span>
        </div>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Coba registrasi</button>
    </form>

    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
        <a class="back-link" href="{{ route('login') }}">Coba login dengan akun demo</a>
    </div>
    <p class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    <p class="auth-caption">Formulir ini mendemonstrasikan registrasi. Penyimpanan akun akan tersedia pada tahap backend.</p>
@endsection

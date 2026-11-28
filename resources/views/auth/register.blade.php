@extends('auth.layout')

@section('title', 'Daftar akun | Sistem Aset ULBI')
@section('heading', 'Daftar akun mahasiswa')

@section('form')
    <form class="auth-form" data-auth-form="register" method="post" action="{{ route('register') }}" novalidate>
        @csrf
        <input type="hidden" name="role" value="mahasiswa">
        <div class="auth-field-pair">
            <div>
                <label class="form-label" for="nim">NIM</label>
                <input class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" type="text"
                    value="{{ old('nim') }}" autocomplete="off" inputmode="numeric" pattern="\d{9}"
                    minlength="9" maxlength="9" placeholder="613230036" required
                    aria-describedby="nim-error">
                <span class="auth-error" id="nim-error" data-error-for="nim">@error('nim') {{ $message }} @enderror</span>
            </div>
            <div>
                <label class="form-label" for="unit">Program studi</label>
                <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required
                    aria-describedby="unit-error">
                    <option value="">Pilih program studi</option>
                    <option value="D3 Administrasi Logistik" @selected(old('unit') === 'D3 Administrasi Logistik')>D3 Administrasi Logistik</option>
                    <option value="D3 Manajemen Pemasaran" @selected(old('unit') === 'D3 Manajemen Pemasaran')>D3 Manajemen Pemasaran</option>
                    <option value="D3 Teknik Informatika" @selected(old('unit') === 'D3 Teknik Informatika')>D3 Teknik Informatika</option>
                    <option value="D4 Logistik Bisnis" @selected(old('unit') === 'D4 Logistik Bisnis')>D4 Logistik Bisnis</option>
                    <option value="D4 Akuntansi Keuangan" @selected(old('unit') === 'D4 Akuntansi Keuangan')>D4 Akuntansi Keuangan</option>
                    <option value="D4 Manajemen Perusahaan" @selected(old('unit') === 'D4 Manajemen Perusahaan')>D4 Manajemen Perusahaan</option>
                    <option value="D4 Teknik Informatika" @selected(old('unit') === 'D4 Teknik Informatika')>D4 Teknik Informatika</option>
                    <option value="S1 Manajemen Logistik" @selected(old('unit') === 'S1 Manajemen Logistik')>S1 Manajemen Logistik</option>
                    <option value="S1 Manajemen Rekayasa" @selected(old('unit') === 'S1 Manajemen Rekayasa')>S1 Manajemen Rekayasa</option>
                    <option value="S1 Manajemen Transportasi" @selected(old('unit') === 'S1 Manajemen Transportasi')>S1 Manajemen Transportasi</option>
                    <option value="S1 Bisnis Digital" @selected(old('unit') === 'S1 Bisnis Digital')>S1 Bisnis Digital</option>
                    <option value="S1 Sains Data" @selected(old('unit') === 'S1 Sains Data')>S1 Sains Data</option>
                </select>
                <span class="auth-error" id="unit-error" data-error-for="unit">@error('unit') {{ $message }} @enderror</span>
            </div>
        </div>
        <div>
            <label class="form-label" for="name">Nama lengkap</label>
            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name') }}" autocomplete="name" required aria-describedby="name-error">
            <span class="auth-error" id="name-error" data-error-for="name">@error('name') {{ $message }} @enderror</span>
        </div>
        <div>
            <label class="form-label" for="email">Email aktif</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
                value="{{ old('email') }}" autocomplete="email" inputmode="email" required
                aria-describedby="email-help email-error">
            <p class="auth-caption" id="email-help">Email apa saja. Kami kirim verifikasi ke email ini.</p>
            <span class="auth-error" id="email-error" data-error-for="email">@error('email') {{ $message }} @enderror</span>
        </div>
        <div>
            <label class="form-label" for="password">Kata sandi</label>
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
            <label class="form-label" for="password_confirmation">Konfirmasi kata sandi</label>
            <div class="auth-password">
                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password"
                    autocomplete="new-password" minlength="8" required aria-describedby="password_confirmation-error">
                <button type="button" data-toggle-password="password_confirmation" aria-controls="password_confirmation"
                    aria-pressed="false">Tampilkan</button>
            </div>
            <span class="auth-error" id="password_confirmation-error" data-error-for="password_confirmation"></span>
        </div>
        <button class="btn btn-primary auth-submit" type="submit" disabled>Daftar akun</button>
    </form>

    <div class="auth-result" data-form-result role="status" tabindex="-1" hidden>
        <h2 data-result-title></h2>
        <p data-result-message></p>
        <a class="back-link" href="{{ route('login') }}">Ke halaman masuk</a>
    </div>
    <p class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@endsection

@extends('layouts.app')

@section('title', 'Beranda | Sistem Aset ULBI')

@section('content')
    <div class="container-xl">
        <section class="hero row align-items-center gy-4 gx-lg-5" aria-labelledby="judul-halaman">
            <div class="col-lg-6">
                <h1 id="judul-halaman">Cek ketersediaan ruang dan sarana</h1>
                <p>Lihat contoh jadwal ruangan dan stok sarana sebelum mengajukan peminjaman.</p>
                <a class="btn btn-primary" href="{{ route('availability') }}">Lihat jadwal dan stok</a>
            </div>

            <div class="col-lg-6">
                <img class="campus-photo" src="{{ asset('assets/ulbi/gedung-ulbi.webp') }}"
                    width="800" height="454" alt="Gedung Universitas Logistik &amp; Bisnis Internasional">
            </div>
        </section>

        <section class="availability" aria-labelledby="jadwal-stok">
            <header class="availability-heading">
                <h2 id="jadwal-stok" tabindex="-1">Jadwal dan stok</h2>
                <span class="demo-label">Data demo</span>
            </header>

            @include('partials.availability-panels', ['panelHeadingLevel' => 3])
        </section>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Beranda | Sistem Aset ULBI')

@section('content')
    <div class="container-xl">
        <section class="hero row align-items-center gy-4 gx-lg-5" aria-labelledby="judul-halaman">
            <div class="col-lg-7">
                <h1 id="judul-halaman">Cek ketersediaan ruang dan sarana</h1>
                <p>Pilih tanggal untuk melihat slot kosong atau cari ruang berdasarkan kapasitas dan fasilitas.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#cari-ruangan">Cari ruangan</a>
                    <a class="back-link" href="{{ route('availability') }}">Lihat jadwal dan stok</a>
                </div>
            </div>

            <div class="col-lg-5">
                <img class="campus-photo" src="{{ asset('assets/ulbi/gedung-ulbi.webp') }}"
                    width="800" height="454" alt="Gedung Universitas Logistik &amp; Bisnis Internasional">
            </div>
        </section>

        <section class="availability" aria-labelledby="jadwal-stok">
            <header class="availability-heading">
                <h2 id="jadwal-stok" tabindex="-1">Temukan ruangan</h2>
                <span class="demo-label">Data demo</span>
            </header>

            <div class="row g-4">
                <div class="col-lg-7">
                    @include('partials.room-calendar')
                </div>
                <div class="col-lg-5">
                    @include('partials.room-search')
                </div>
            </div>
        </section>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Beranda | Sistem Aset ULBI')

@section('content')
    <div class="container-xl">
        <section class="hero row align-items-center gy-4 gx-lg-5" aria-labelledby="judul-halaman">
            <div class="col-lg-6">
                <h1 id="judul-halaman">Cek ketersediaan ruang dan sarana</h1>
                <p>Lihat contoh jadwal ruangan dan stok sarana sebelum mengajukan peminjaman.</p>
                <a class="btn btn-primary" href="#jadwal-stok">Lihat jadwal dan stok</a>
            </div>

            <div class="col-lg-6">
                <img class="campus-photo" src="{{ asset('assets/ulbi/gedung-ulbi.webp') }}"
                    width="800" height="454" alt="Gedung Universitas Logistik &amp; Bisnis Internasional">
            </div>
        </section>

        <section class="availability" id="jadwal-stok" aria-labelledby="judul-ketersediaan" tabindex="-1">
            <header class="availability-heading">
                <h2 id="judul-ketersediaan">Jadwal dan stok</h2>
                <span class="demo-label">Data demo</span>
            </header>

            <div class="row g-4">
                <div class="col-lg-7">
                    <section class="availability-panel" aria-labelledby="judul-jadwal">
                        <h3 class="panel-heading" id="judul-jadwal">Jadwal ruangan</h3>
                        @foreach ($rooms as $room)
                            <article class="asset-entry">
                                <div class="asset-heading">
                                    <div>
                                        <h4>{{ $room['name'] }}</h4>
                                        <p class="asset-detail">Kapasitas {{ $room['capacity'] }} orang</p>
                                    </div>
                                    <span class="asset-status status-{{ $room['statusStyle'] }}">
                                        {{ $room['status'] }}
                                    </span>
                                </div>

                                <dl class="asset-values">
                                    @foreach ($room['schedule'] as $label => $slot)
                                        <div>
                                            <dt>{{ $label }}</dt>
                                            <dd>{{ $slot }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </article>
                        @endforeach
                    </section>
                </div>

                <div class="col-lg-5">
                    <section class="availability-panel" aria-labelledby="judul-stok">
                        <h3 class="panel-heading" id="judul-stok">Stok sarana</h3>
                        <article class="asset-entry">
                            <div class="asset-heading">
                                <h4>{{ $equipment['name'] }}</h4>
                                <span class="asset-status status-low">Stok tidak cukup</span>
                            </div>

                            <dl class="asset-values">
                                <div>
                                    <dt>Stok tersedia</dt>
                                    <dd>{{ $equipment['available'] }} unit</dd>
                                </div>
                                <div>
                                    <dt>Jumlah diminta</dt>
                                    <dd>{{ $equipment['requested'] }} unit</dd>
                                </div>
                            </dl>
                        </article>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

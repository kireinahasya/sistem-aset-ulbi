@extends('layouts.app')

@section('title', $room['name'].' | Sistem Aset ULBI')

@section('content')
    <div class="container-xl availability-page">
        <a class="back-link" href="{{ route('rooms.index') }}">Kembali ke katalog</a>

        <header class="availability-heading availability-page-heading">
            <h1>{{ $room['name'] }}</h1>
        </header>

        <div class="row g-3">
            <div class="col-md-7">
                <section class="availability-panel" aria-labelledby="fasilitas-ruangan">
                    <h2 class="panel-heading" id="fasilitas-ruangan">Fasilitas bawaan</h2>
                    <ul class="list-unstyled mb-0">
                        @foreach ($room['facilities'] as $code)
                            <li class="asset-entry">{{ $facilityLabels[$code] }}</li>
                        @endforeach
                    </ul>
                </section>
            </div>

            <div class="col-md-5">
                <section class="availability-panel room-card" aria-labelledby="kapasitas-ruangan">
                    <h2 id="kapasitas-ruangan">Kapasitas</h2>
                    <p class="room-capacity">{{ $room['capacity'] }} orang</p>
                    <a class="back-link" href="{{ route('home') }}#ketersediaan">Lihat kalender ketersediaan</a>
                </section>
            </div>
        </div>
    </div>
@endsection

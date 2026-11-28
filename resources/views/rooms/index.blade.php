@extends('layouts.app')

@section('title', 'Katalog ruangan | Sistem Aset ULBI')

@section('content')
    <div class="container-xl availability-page">
        <header class="availability-heading availability-page-heading">
            <h1>Katalog ruangan</h1>
        </header>

        <ul class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3 list-unstyled mb-0">
            @foreach ($rooms as $room)
                <li class="col">
                    <article class="availability-panel room-card">
                        <h2>{{ $room['name'] }}</h2>
                        <p class="room-capacity">Kapasitas {{ $room['capacity'] }} orang</p>
                        <p class="room-card-facilities">
                            {{ implode(' · ', array_map(fn ($code) => $facilityLabels[$code], $room['facilities'])) }}
                        </p>
                        <a class="back-link mt-auto" href="{{ route('rooms.show', $room['slug']) }}"
                            aria-label="Lihat detail {{ $room['name'] }}">Lihat detail</a>
                    </article>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

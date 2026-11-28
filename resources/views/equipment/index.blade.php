@extends('layouts.app')

@section('title', 'Sarana tambahan | Sistem Aset ULBI')

@section('content')
    <div class="container-xl availability-page">
        <header class="availability-heading availability-page-heading">
            <h1>Sarana tambahan</h1>
        </header>
        <p class="catalog-intro">Pilih perlengkapan yang diperlukan untuk kegiatan Anda.</p>
        <ul class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3 list-unstyled">
            @foreach ($equipment as $item)
                <li class="col">
                    <article class="availability-panel room-card">
                        <h2>{{ $item['name'] }}</h2>
                        <p class="room-card-facilities">{{ $item['description'] }}</p>
                        <dl class="asset-values equipment-values">
                            <div><dt>Stok tercatat</dt><dd>{{ $item['stock'] }} {{ $item['unit'] }}</dd></div>
                            <div><dt>Tersedia</dt><dd>{{ $item['available'] }} {{ $item['unit'] }}</dd></div>
                        </dl>
                        <p class="asset-detail mb-2">Kondisi {{ strtolower($item['condition']) }}</p>
                        @if ($item['available'] > 0)
                            <a class="back-link mt-auto" href="{{ route('borrowings.create', ['sarana' => $item['slug']]) }}"
                                aria-label="Pilih {{ $item['name'] }}">Pilih sarana</a>
                        @else
                            <p class="asset-status status-low mt-auto mb-0">Belum tersedia</p>
                        @endif
                    </article>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Jadwal dan stok | Sistem Aset ULBI')

@section('content')
    <div class="container-xl availability-page">
        <a class="back-link" href="{{ route('home') }}">Kembali ke beranda</a>

        <header class="availability-heading availability-page-heading">
            <h1>Jadwal dan stok</h1>
        </header>

        @include('partials.availability-panels', ['panelHeadingLevel' => 2])
    </div>
@endsection

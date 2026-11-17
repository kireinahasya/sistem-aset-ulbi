<?php

use Illuminate\Support\Facades\Route;

$availabilityDemo = [
    'rooms' => [
        [
            'name' => 'Ruang A',
            'capacity' => 40,
            'status' => 'Jadwal bentrok',
            'statusStyle' => 'conflict',
            'schedule' => [
                'Jadwal terisi' => '09.00–11.00 WIB',
                'Waktu diminta' => '10.00–12.00 WIB',
            ],
        ],
        [
            'name' => 'Ruang B',
            'capacity' => 50,
            'status' => 'Tersedia',
            'statusStyle' => 'available',
            'schedule' => [
                'Slot tersedia' => '10.00–12.00 WIB',
            ],
        ],
    ],
    'equipment' => [
        'name' => 'Mikrofon nirkabel',
        'requested' => 4,
        'available' => 2,
    ],
];

Route::view('/', 'home', $availabilityDemo)->name('home');
Route::view('/jadwal-stok', 'availability', $availabilityDemo)->name('availability');

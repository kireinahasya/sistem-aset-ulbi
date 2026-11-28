<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\EquipmentCatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomCatalogController;
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

Route::get('/', HomeController::class)->name('home');
Route::view('/masuk', 'auth.login')->name('login');
Route::view('/daftar', 'auth.register')->name('register');
Route::view('/lupa-kata-sandi', 'auth.forgot-password')->name('password.request');
Route::view('/reset-kata-sandi', 'auth.reset-password')->name('password.reset');
Route::get('/ruangan', [RoomCatalogController::class, 'index'])->name('rooms.index');
Route::get('/ruangan/{room}', [RoomCatalogController::class, 'show'])->name('rooms.show');
Route::get('/sarana', EquipmentCatalogController::class)->name('equipment.index');
Route::get('/peminjaman/baru', [BorrowingController::class, 'create'])->name('borrowings.create');
Route::view('/jadwal-stok', 'availability', $availabilityDemo)->name('availability');

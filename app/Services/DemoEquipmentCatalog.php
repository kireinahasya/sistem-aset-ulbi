<?php

namespace App\Services;

final class DemoEquipmentCatalog
{
    public function items(): array
    {
        return [
            ['slug' => 'mikrofon-nirkabel', 'name' => 'Mikrofon nirkabel', 'unit' => 'unit', 'stock' => 6, 'available' => 2, 'condition' => 'Baik', 'description' => 'Mikrofon untuk pembicara dan sesi tanya jawab.'],
            ['slug' => 'tiang-bendera', 'name' => 'Tiang dan tatakan bendera', 'unit' => 'set', 'stock' => 4, 'available' => 3, 'condition' => 'Baik', 'description' => 'Satu set terdiri dari tiang beserta tatakannya.'],
            ['slug' => 'sofa-dosen', 'name' => 'Sofa dosen', 'unit' => 'unit', 'stock' => 4, 'available' => 2, 'condition' => 'Baik', 'description' => 'Tempat duduk untuk dosen, pembicara, atau tamu kegiatan.'],
            ['slug' => 'meja-tamu', 'name' => 'Meja tamu', 'unit' => 'unit', 'stock' => 5, 'available' => 3, 'condition' => 'Baik', 'description' => 'Meja pendamping untuk area tamu dan pembicara.'],
            ['slug' => 'speaker-portabel', 'name' => 'Speaker portabel', 'unit' => 'unit', 'stock' => 2, 'available' => 0, 'condition' => 'Dalam perawatan', 'description' => 'Pengeras suara yang dapat dipindahkan ke lokasi kegiatan.'],
        ];
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoomFinderTest extends TestCase
{
    public function test_calendar_changes_the_available_rooms_and_form_date(): void
    {
        $tuesday = $this->get('/?tanggal=2026-11-17')->assertOk();
        $tuesday->assertViewHas('availableRooms', fn (array $rooms): bool => array_column($rooms, 'name') === ['Ruang A', 'Ruang B', 'Ruang D', 'Ruang E']);
        $tuesday->assertSee('value="2026-11-17"', false);

        $this->get('/?tanggal=2026-11-18')->assertOk()
            ->assertViewHas('availableRooms', fn (array $rooms): bool => array_column($rooms, 'name') === ['Ruang A', 'Ruang B', 'Ruang C', 'Ruang D']);
    }

    public function test_recommendations_respect_time_facilities_and_capacity_and_rank_by_spare_seats(): void
    {
        $query = [
            'cari' => 1,
            'tanggal' => '2026-11-17',
            'jam_mulai' => '11:00',
            'jam_selesai' => '12:00',
            'jumlah_peserta' => 35,
            'fasilitas' => ['ac', 'proyektor'],
        ];

        $this->get('/?'.http_build_query($query))->assertOk()
            ->assertViewHas('recommendations', fn (array $rooms): bool => array_column($rooms, 'name') === ['Ruang A', 'Ruang D']
                && array_column($rooms, 'spareSeats') === [5, 45]);

        $query['jam_mulai'] = '10:00';

        $this->get('/?'.http_build_query($query))->assertOk()
            ->assertViewHas('recommendations', fn (array $rooms): bool => array_column($rooms, 'name') === ['Ruang D']);

        $query['jumlah_peserta'] = 100;

        $this->get('/?'.http_build_query($query))->assertOk()
            ->assertSeeText('Tidak ada ruangan yang cocok.');
    }

    public function test_search_explains_invalid_date_times_and_participant_count(): void
    {
        $this->get('/?cari=1&tanggal=2026-02-30&jam_mulai=10:00&jam_selesai=09:00&jumlah_peserta=0')
            ->assertOk()
            ->assertSeeText('Pilih tanggal yang valid.')
            ->assertSeeText('Jam selesai harus setelah jam mulai.')
            ->assertSeeText('Jumlah peserta minimal 1 orang.');
    }

    public function test_search_rejects_times_outside_demo_hours_and_unlisted_facilities(): void
    {
        $query = [
            'cari' => 1,
            'tanggal' => '2026-11-17',
            'jam_mulai' => '07:30',
            'jam_selesai' => '17:30',
            'jumlah_peserta' => 30,
            'fasilitas' => ['fasilitas-lain'],
        ];

        $this->get('/?'.http_build_query($query))->assertOk()
            ->assertSeeText('Jam mulai paling awal 08.00 WIB.')
            ->assertSeeText('Jam selesai paling akhir 17.00 WIB.')
            ->assertSeeText('Pilih fasilitas dari daftar.');
    }
}

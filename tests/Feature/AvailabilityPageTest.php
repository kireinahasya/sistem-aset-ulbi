<?php

namespace Tests\Feature;

use Tests\TestCase;

class AvailabilityPageTest extends TestCase
{
    public function test_the_home_page_links_to_the_availability_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="'.route('availability').'"', false)
            ->assertSeeText('Lihat jadwal dan stok');
    }

    public function test_the_availability_page_displays_demo_data_and_a_link_home(): void
    {
        $this->get('/jadwal-stok')
            ->assertOk()
            ->assertViewIs('availability')
            ->assertSeeText('Jadwal bentrok')
            ->assertSeeText('Stok tidak cukup')
            ->assertSeeText('Kembali ke beranda')
            ->assertSee('href="'.route('home').'"', false);
    }
}

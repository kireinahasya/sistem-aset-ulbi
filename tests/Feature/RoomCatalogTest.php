<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoomCatalogTest extends TestCase
{
    public function test_the_catalog_links_to_each_rooms_own_detail_page(): void
    {
        $catalog = $this->get('/ruangan')->assertOk();

        foreach (['a', 'b', 'c', 'd', 'e'] as $letter) {
            $slug = 'ruang-'.$letter;

            $catalog->assertSee('href="'.route('rooms.show', $slug).'"', false);
            $this->get('/ruangan/'.$slug)
                ->assertOk()
                ->assertViewHas('room', fn (array $room): bool => $room['slug'] === $slug);
        }
    }

    public function test_a_room_only_lists_its_own_builtin_facilities(): void
    {
        $this->get('/ruangan/ruang-c')
            ->assertOk()
            ->assertSeeText('24 orang')
            ->assertSeeText('AC')
            ->assertSeeText('Papan tulis')
            ->assertDontSeeText('Proyektor')
            ->assertDontSeeText('Sound system');
    }

    public function test_an_unknown_room_returns_not_found(): void
    {
        $this->get('/ruangan/tidak-ada')->assertNotFound();
    }
}

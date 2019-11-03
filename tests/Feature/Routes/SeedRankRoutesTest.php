<?php

namespace Tests\Feature\Routes;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeedRankRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_seed_ranks()
    {
        $seedRanks = factory(SeedRank::class, 10)->create();

        $response = $this->get('/api/seed-ranks');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_seed_rank()
    {
        $seedRank = factory(SeedRank::class)->create();

        $response = $this->get("/api/seed-ranks/{$seedRank->id}");

        $response->assertStatus(200);
        $response->assertJson($seedRank->toArray());
    }
}

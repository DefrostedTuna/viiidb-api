<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SeedRankController;
use App\Models\SeedRank;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SeedRankControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_seed_ranks()
    {
        $seedRanks = factory(SeedRank::class, 10)->create();

        $seedRankController = new SeedRankController(new SeedRank);

        $response = $seedRankController->index(new Request());

        // Controller should return a collection of Seed Ranks.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_seed_rank()
    {
        $seedRank = factory(SeedRank::class)->create();

        $seedRankController = new SeedRankController(new SeedRank);

        $response = $seedRankController->show(new Request(), $seedRank);

        // The controller should return the instance of a Seed Rank that was found via 
        // route model binding. Since we are mocking this result by injecting the
        // Seed Rank into the method, we should get the same Seed Rank back.
        $this->assertInstanceOf(SeedRank::class, $response);
        $this->assertEquals($seedRank, $response);
    }
}

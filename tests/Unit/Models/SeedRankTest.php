<?php

namespace Tests\Unit\Models;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedRankTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('seed_ranks', $seedRank->getTable());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $seedRank = new SeedRank();

        $this->assertEquals([], $seedRank->getFillable());
    }

    /** @test */
    public function it_hides_the_created_at_field_from_the_output()
    {
        $seedRank = new SeedRank();

        $this->assertContains('created_at', $seedRank->getHidden());
    }

    /** @test */
    public function it_hides_the_updated_at_field_from_the_output()
    {
        $seedRank = new SeedRank();

        $this->assertContains('updated_at', $seedRank->getHidden());
    }

    /** @test */
    public function it_stores_a_seed_rank_in_the_database()
    {
        $seedRank = factory(SeedRank::class)->make();

        $seedRank->save();

        $this->assertDatabaseHas('seed_ranks', [
            'id' => $seedRank->id,
        ]);
    }
}

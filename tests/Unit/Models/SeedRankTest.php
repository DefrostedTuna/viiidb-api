<?php

namespace Tests\Unit\Models;

use App\Models\SeedRank;
use App\Traits\Filterable;
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
    public function it_hides_the_deleted_at_field_from_the_output()
    {
        $seedRank = new SeedRank();

        $this->assertContains('deleted_at', $seedRank->getHidden());
    }

    /** @test */
    public function it_casts_the_rank_column_to_a_string()
    {
        $seedRank = new SeedRank();
        $casts = $seedRank->getCasts();

        $this->assertArrayHasKey('rank', $casts);
        $this->assertEquals('string', $casts['rank']);
    }

    /** @test */
    public function it_casts_the_salary_column_to_an_integer()
    {
        $seedRank = new SeedRank();
        $casts = $seedRank->getCasts();

        $this->assertArrayHasKey('salary', $casts);
        $this->assertEquals('integer', $casts['salary']);
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

    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class, 
            class_uses(SeedRank::class)
        ));
    }

    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $seedRank = new SeedRank();
        $shouldBeFilterable = [
            'rank',
            'salary',
        ];

        $this->assertEquals($shouldBeFilterable, $seedRank->getFilterableFields());
    }
}

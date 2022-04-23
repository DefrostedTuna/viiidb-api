<?php

namespace Tests\Unit\Models;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedRankTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table(): void
    {
        $seedRank = new SeedRank();

        $this->assertEquals('seed_ranks', $seedRank->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering(): void
    {
        $seedRank = new SeedRank();

        $this->assertEquals('salary', $seedRank->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption(): void
    {
        $seedRank = new SeedRank();

        $visibleFields = [
            'id',
            'rank',
            'salary',
        ];

        $this->assertEquals($visibleFields, $seedRank->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field(): void
    {
        $seedRank = new SeedRank();

        $expected = [
            'id' => 'string',
            'rank' => 'string',
            'salary' => 'integer',
        ];

        $this->assertEquals($expected, $seedRank->getCasts());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable(): void
    {
        $seedRank = new SeedRank();

        $expected = [
            'rank',
            'salary',
        ];

        $this->assertEquals($expected, $seedRank->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name(): void
    {
        $seedRank = new SeedRank();

        $this->assertEquals('rank', $seedRank->getRouteKeyName());
    }
}

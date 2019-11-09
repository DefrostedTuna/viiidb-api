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
    public function it_sets_the_primary_key_type_to_string()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('string', $seedRank->getKeyType());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $seedRank = new SeedRank();

        $this->assertEquals([], $seedRank->getFillable());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
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
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $seedRank = new SeedRank();

        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',    
        ];

        $this->assertEquals($hiddenFields, $seedRank->getHidden());
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

    /** @test */
    public function it_orders_results_by_salary()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('salary', $seedRank->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('asc', $seedRank->getOrderByDirection());
    }
}

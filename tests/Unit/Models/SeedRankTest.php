<?php

namespace Tests\Unit\Models;

use App\Models\SeedRank;
use App\Traits\FiltersRecordsByFields;
use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class SeedRankTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_explicitly_disables_incrementing_primary_keys()
    {
        $seedRank = new SeedRank();

        $this->assertFalse($seedRank->getIncrementing());
    }

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('seed_ranks', $seedRank->getTable());
    }

    /** @test */
    public function it_sets_the_primary_key_column_explicitly()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('id', $seedRank->getKeyName());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('string', $seedRank->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
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
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $seedRank = new SeedRank();
        $fields = $seedRank->getCasts();

        $expected = [
            'id' => 'string',
            'rank' => 'string',
            'salary' => 'integer',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable()
    {
        $seedRank = new SeedRank();

        $expected = [
            'rank',
            'salary',
        ];

        $this->assertEquals($expected, $seedRank->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_filterable()
    {
        $seedRank = new SeedRank();

        $expected = [
            'rank',
            'salary',
        ];

        $this->assertEquals($expected, $seedRank->getFilterableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $seedRank = new SeedRank();

        $this->assertEquals('rank', $seedRank->getRouteKeyName());
    }

    /** @test */
    public function it_uses_uuids_for_the_primary_key()
    {
        $this->assertTrue(in_array(
            Uuids::class,
            class_uses(SeedRank::class)
        ));
    }

    /** @test */
    public function it_will_not_allow_the_uuid_to_be_changed()
    {
        $seedRank = SeedRank::factory()->create();

        $seedRank->id = 'not-original-value';
        $seedRank->save();

        $this->assertFalse($seedRank->id === 'not-original-value');
    }

    /** @test */
    public function it_can_order_query_results()
    {
        $this->assertTrue(in_array(
            OrdersQueryResults::class,
            class_uses(SeedRank::class)
        ));
    }

    /** @test */
    public function it_includes_search_functionality()
    {
        $this->assertTrue(in_array(
            Searchable::class,
            class_uses(SeedRank::class)
        ));
    }

    /** @test */
    public function it_includes_the_ability_to_filter_records_by_fields()
    {
        $this->assertTrue(in_array(
            FiltersRecordsByFields::class,
            class_uses(SeedRank::class)
        ));
    }
}

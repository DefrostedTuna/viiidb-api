<?php

namespace Tests\Unit\Models;

use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table(): void
    {
        $location = new Location();

        $this->assertEquals('locations', $location->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering(): void
    {
        $location = new Location();

        $this->assertEquals('sort_id', $location->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption(): void
    {
        $location = new Location();

        $visibleFields = [
            'id',
            'region_id',
            'parent_id',
            'sort_id',
            'slug',
            'name',
            'notes',
            'region',
            'parent',
            'locations',
        ];

        $this->assertEquals($visibleFields, $location->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field(): void
    {
        $location = new Location();

        $expected = [
            'id' => 'string',
            'region_id' => 'string',
            'parent_id' => 'string',
            'sort_id' => 'integer',
            'slug' => 'string',
            'name' => 'string',
            'notes' => 'string',
        ];

        $this->assertEquals($expected, $location->getCasts());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable(): void
    {
        $location = new Location();

        $expected = [
            'slug',
            'name',
            'notes',
        ];

        $this->assertEquals($expected, $location->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_relations_that_are_available_to_include_with_the_resource(): void
    {
        $location = new Location();

        $expected = [
            'region',
            'parent',
            'locations',
        ];

        $this->assertEquals($expected, $location->getAvailableIncludes());
    }

    /** @test */
    public function it_explicitly_defines_the_default_relations_to_include_with_the_resource(): void
    {
        $location = new Location();

        $expected = [];

        $this->assertEquals($expected, $location->getDefaultIncludes());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name(): void
    {
        $location = new Location();

        $this->assertEquals('slug', $location->getRouteKeyName());
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\Location;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $location = new Location();
    
        $this->assertEquals('locations', $location->getTable());
    }
    
    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $location = new Location();
    
        $this->assertEquals('string', $location->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $location = new Location();

        $this->assertEquals('name', $location->getRouteKeyName());
    }
    
    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $location = new Location();
    
        $this->assertEquals([], $location->getFillable());
    }
    
    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $location = new Location();
    
        $visibleFields = [
            'id',
            'region_id',
            'name',
            'description',
            'area',
            'region',
        ];
    
        $this->assertEquals($visibleFields, $location->getVisible());
    }
    
    /** @test */
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $location = new Location();
    
        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    
        $this->assertEquals($hiddenFields, $location->getHidden());
    }
    
    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $location = new Location();
        $fields = $location->getCasts();

        $expected = [
            'id'            => 'string',
            'region_id'     => 'string',
            'name'          => 'string',
            'description'   => 'string',
            'area'          => 'string',
        ];
    
        $this->assertEquals($expected, $fields);
    }
    
    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class,
            class_uses(Location::class)
        ));
    }
    
    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $location = new Location();
        $shouldBeFilterable = [
            'name',
            'area',
        ];
    
        $this->assertEquals($shouldBeFilterable, $location->getFilterableFields());
    }
    
    /** @test */
    public function it_orders_results_by_name()
    {
        $location = new Location();
    
        $this->assertEquals('name', $location->getOrderByField());
    }
    
    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $location = new Location();
    
        $this->assertEquals('asc', $location->getOrderByDirection());
    }

    /** @test */
    public function it_defines_the_relations_associated_with_the_model()
    {
        $location = new Location();

        // Region.
        $this->assertInstanceOf(BelongsTo::class, $location->region());
        $this->assertInstanceOf(Location::class, $location->region()->getRelated());
    }

    /** @test */
    public function it_explicitly_defines_the_relations_to_be_loaded_through_filters()
    {
        $location = new Location();

        $expected = [
            'region',
        ];

        $this->assertEquals($expected, $location->getValidRelations());
    }
}

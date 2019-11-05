<?php

namespace Tests\Unit\Models;

use App\Models\Location;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationTest extends TestCase
{
    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $location = new Location();

        $this->assertEquals('locations', $location->getTable());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $location = new Location();

        $this->assertEquals([], $location->getFillable());
    }

    /** @test */
    public function it_hides_the_created_at_field_from_the_output()
    {
        $location = new Location();

        $this->assertContains('created_at', $location->getHidden());
    }

    /** @test */
    public function it_hides_the_updated_at_field_from_the_output()
    {
        $location = new Location();

        $this->assertContains('updated_at', $location->getHidden());
    }

    /** @test */
    public function it_hides_the_deleted_at_field_from_the_output()
    {
        $location = new Location();

        $this->assertContains('deleted_at', $location->getHidden());
    }

    /** @test */
    public function it_casts_the_name_column_to_a_string()
    {
        $location = new Location();
        $casts = $location->getCasts();

        $this->assertArrayHasKey('name', $casts);
        $this->assertEquals('string', $casts['name']);
    }

    /** @test */
    public function it_casts_the_description_column_to_a_string()
    {
        $location = new Location();
        $casts = $location->getCasts();

        $this->assertArrayHasKey('description', $casts);
        $this->assertEquals('string', $casts['description']);
    }

    /** @test */
    public function it_casts_the_area_column_to_a_string()
    {
        $location = new Location();
        $casts = $location->getCasts();

        $this->assertArrayHasKey('area', $casts);
        $this->assertEquals('string', $casts['area']);
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
    public function it_can_belong_to_a_region()
    {
        $location = new Location();

        $this->assertInstanceOf(BelongsTo::class, $location->region());
        $this->assertInstanceOf(Location::class, $location->region()->getRelated());
    }
}

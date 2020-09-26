<?php

namespace Tests\Unit\Models;

use App\Models\Element;
use App\Traits\Filterable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $element = new Element();

        $this->assertEquals('elements', $element->getTable());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $element = new Element();

        $this->assertEquals('string', $element->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $element = new Element();

        $this->assertEquals('name', $element->getRouteKeyName());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $element = new Element();

        $this->assertEquals([], $element->getFillable());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $element = new Element();

        $visibleFields = [
            'id',
            'name',
        ];

        $this->assertEquals($visibleFields, $element->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $element = new Element();

        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        $this->assertEquals($hiddenFields, $element->getHidden());
    }

    /** @test */
    public function it_casts_the_name_column_to_a_string()
    {
        $element = new Element();
        $casts = $element->getCasts();

        $this->assertArrayHasKey('name', $casts);
        $this->assertEquals('string', $casts['name']);
    }

    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class,
            class_uses(Element::class)
        ));
    }

    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $element = new Element();
        $shouldBeFilterable = [
            'name',
        ];

        $this->assertEquals($shouldBeFilterable, $element->getFilterableFields());
    }

    /** @test */
    public function it_orders_results_by_name()
    {
        $element = new Element();

        $this->assertEquals('name', $element->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $element = new Element();

        $this->assertEquals('asc', $element->getOrderByDirection());
    }
}

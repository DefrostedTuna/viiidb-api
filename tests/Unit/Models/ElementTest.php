<?php

namespace Tests\Unit\Models;

use App\Models\Element;
use Tests\TestCase as TestCase;

class ElementTest extends TestCase
{
    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $element = new Element();

        $this->assertEquals('elements', $element->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
    {
        $element = new Element();

        $this->assertEquals('sort_id', $element->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $element = new Element();

        $visibleFields = [
            'id',
            'sort_id',
            'name',
        ];

        $this->assertEquals($visibleFields, $element->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $element = new Element();
        $fields = $element->getCasts();

        $expected = [
            'id'      => 'string',
            'sort_id' => 'integer',
            'name'    => 'string',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable()
    {
        $element = new Element();

        $expected = [
            'name',
        ];

        $this->assertEquals($expected, $element->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_filterable()
    {
        $element = new Element();

        $expected = [
            'name',
        ];

        $this->assertEquals($expected, $element->getFilterableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $element = new Element();

        $this->assertEquals('name', $element->getRouteKeyName());
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\Stat;
use Tests\TestCase as TestCase;

class StatTest extends TestCase
{
    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $stat = new Stat();

        $this->assertEquals('stats', $stat->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
    {
        $stat = new Stat();

        $this->assertEquals('sort_id', $stat->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $stat = new Stat();

        $visibleFields = [
            'id',
            'sort_id',
            'name',
            'abbreviation',
        ];

        $this->assertEquals($visibleFields, $stat->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $stat = new Stat();
        $fields = $stat->getCasts();

        $expected = [
            'id'           => 'string',
            'sort_id'      => 'integer',
            'name'         => 'string',
            'abbreviation' => 'string',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable()
    {
        $stat = new Stat();

        $expected = [];

        $this->assertEquals($expected, $stat->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_filterable()
    {
        $stat = new Stat();

        $expected = [];

        $this->assertEquals($expected, $stat->getFilterableFields());
    }
}

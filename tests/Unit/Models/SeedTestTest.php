<?php

namespace Tests\Unit\Models;

use App\Models\SeedTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class SeedTestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('seed_tests', $seedTest->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('level', $seedTest->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $seedTest = new SeedTest();

        $visibleFields = [
            'id',
            'level',
            'testQuestions',
        ];

        $this->assertEquals($visibleFields, $seedTest->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $seedTest = new SeedTest();
        $fields = $seedTest->getCasts();

        $expected = [
            'id'    => 'string',
            'level' => 'integer',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable()
    {
        $seedTest = new SeedTest();

        $expected = [
            'level',
        ];

        $this->assertEquals($expected, $seedTest->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_filterable()
    {
        $seedTest = new SeedTest();

        $expected = [
            'level',
        ];

        $this->assertEquals($expected, $seedTest->getFilterableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_relations_that_are_available_to_include_with_the_resource()
    {
        $seedTest = new SeedTest();

        $expected = [
            'testQuestions',
        ];

        $this->assertEquals($expected, $seedTest->getAvailableIncludes());
    }

    /** @test */
    public function it_explicitly_defines_the_default_relations_to_include_with_the_resource()
    {
        $seedTest = new SeedTest();

        $expected = [];

        $this->assertEquals($expected, $seedTest->getDefaultIncludes());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('level', $seedTest->getRouteKeyName());
    }
}

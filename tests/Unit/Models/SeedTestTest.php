<?php

namespace Tests\Unit\Models;

use App\Models\SeedTest;
use App\Traits\FiltersRecordsByFields;
use App\Traits\LoadsRelationsThroughServices;
use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class SeedTestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_explicitly_disables_incrementing_primary_keys()
    {
        $seedTest = new SeedTest();

        $this->assertFalse($seedTest->getIncrementing());
    }

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('seed_tests', $seedTest->getTable());
    }

    /** @test */
    public function it_sets_the_primary_key_column_explicitly()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('id', $seedTest->getKeyName());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('string', $seedTest->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('level', $seedTest->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('asc', $seedTest->getOrderByDirection());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $seedTest = new SeedTest();

        $this->assertEquals([], $seedTest->getFillable());
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
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $seedTest = new SeedTest();

        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        $this->assertEquals($hiddenFields, $seedTest->getHidden());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $seedTest = new SeedTest();
        $fields = $seedTest->getCasts();

        $expected = [
            'id'    => 'string',
            'level' => 'int',
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

    /** @test */
    public function it_uses_uuids_for_the_primary_key()
    {
        $this->assertTrue(in_array(
            Uuids::class,
            class_uses(SeedTest::class)
        ));
    }

    /** @test */
    public function it_will_not_allow_the_uuid_to_be_changed()
    {
        $seedTest = SeedTest::factory()->create();

        $seedTest->id = 'not-original-value';
        $seedTest->save();

        $this->assertFalse($seedTest->id === 'not-original-value');
    }

    /** @test */
    public function it_can_order_query_results()
    {
        $this->assertTrue(in_array(
            OrdersQueryResults::class,
            class_uses(SeedTest::class)
        ));
    }

    /** @test */
    public function it_includes_search_functionality()
    {
        $this->assertTrue(in_array(
            Searchable::class,
            class_uses(SeedTest::class)
        ));
    }

    /** @test */
    public function it_includes_the_ability_to_filter_records_by_fields()
    {
        $this->assertTrue(in_array(
            FiltersRecordsByFields::class,
            class_uses(SeedTest::class)
        ));
    }

    public function it_loads_relations_through_services()
    {
        $this->assertTrue(in_array(
            LoadsRelationsThroughServices::class,
            class_uses(SeedTest::class)
        ));
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class SeedTestTest extends TestCase
{
    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('seed_tests', $seedTest->getTable());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $seedTest = new SeedTest();

        $this->assertEquals('string', $seedTest->getKeyType());
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
            'questions',
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
    public function it_casts_the_level_column_to_an_integer()
    {
        $seedTest = new SeedTest();
        $casts = $seedTest->getCasts();

        $this->assertArrayHasKey('level', $casts);
        $this->assertEquals('integer', $casts['level']);
    }

    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class, 
            class_uses(SeedTest::class)
        ));
    }

    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $seedTest = new SeedTest();
        $shouldBeFilterable = [
            'level',
        ];

        $this->assertEquals($shouldBeFilterable, $seedTest->getFilterableFields());
    }

    /** @test */
    public function it_allows_questions_to_be_loaded_through_filters()
    {
        $seedTest = new SeedTest();

        $this->assertContains('questions', $seedTest->getValidRelations());
    }

    /** @test */
    public function it_orders_results_by_level()
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
    public function it_can_have_many_questions()
    {
        $seedTest = new SeedTest();

        $this->assertInstanceOf(HasMany::class, $seedTest->questions());
        $this->assertInstanceOf(TestQuestion::class, $seedTest->questions()->getRelated());
    }
}

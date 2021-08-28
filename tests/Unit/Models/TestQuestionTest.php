<?php

namespace Tests\Unit\Models;

use App\Models\TestQuestion;
use App\Traits\FiltersRecordsByFields;
use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class TestQuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_explicitly_disables_incrementing_primary_keys()
    {
        $testQuestion = new TestQuestion();

        $this->assertFalse($testQuestion->getIncrementing());
    }

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('test_questions', $testQuestion->getTable());
    }

    /** @test */
    public function it_sets_the_primary_key_column_explicitly()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('id', $testQuestion->getKeyName());
    }

    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('string', $testQuestion->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('sort_id', $testQuestion->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('asc', $testQuestion->getOrderByDirection());
    }

    /** @test */
    public function it_does_not_allow_properties_to_be_assigned_in_mass()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals([], $testQuestion->getFillable());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption()
    {
        $testQuestion = new TestQuestion();

        $visibleFields = [
            'id',
            'sort_id',
            'seed_test_id',
            'question_number',
            'question',
            'answer',
        ];

        $this->assertEquals($visibleFields, $testQuestion->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_hidden_fields_for_api_consumption()
    {
        $testQuestion = new TestQuestion();

        $hiddenFields = [
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        $this->assertEquals($hiddenFields, $testQuestion->getHidden());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field()
    {
        $testQuestion = new TestQuestion();
        $fields = $testQuestion->getCasts();

        $expected = [
            'id'              => 'string',
            'sort_id'         => 'integer',
            'seed_test_id'    => 'string',
            'question_number' => 'integer',
            'question'        => 'string',
            'answer'          => 'boolean',
        ];

        $this->assertEquals($expected, $fields);
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_searchable()
    {
        $testQuestion = new TestQuestion();

        $expected = [
            'question_number',
            'question',
            'answer',
        ];

        $this->assertEquals($expected, $testQuestion->getSearchableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_fields_that_are_filterable()
    {
        $testQuestion = new TestQuestion();

        $expected = [
            'question_number',
            'question',
            'answer',
        ];

        $this->assertEquals($expected, $testQuestion->getFilterableFields());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('id', $testQuestion->getRouteKeyName());
    }

    /** @test */
    public function it_uses_uuids_for_the_primary_key()
    {
        $this->assertTrue(in_array(
            Uuids::class,
            class_uses(TestQuestion::class)
        ));
    }

    /** @test */
    public function it_will_not_allow_the_uuid_to_be_changed()
    {
        $testQuestion = TestQuestion::factory()->create();

        $testQuestion->id = 'not-original-value';
        $testQuestion->save();

        $this->assertFalse($testQuestion->id === 'not-original-value');
    }

    /** @test */
    public function it_can_order_query_results()
    {
        $this->assertTrue(in_array(
            OrdersQueryResults::class,
            class_uses(TestQuestion::class)
        ));
    }

    /** @test */
    public function it_includes_search_functionality()
    {
        $this->assertTrue(in_array(
            Searchable::class,
            class_uses(TestQuestion::class)
        ));
    }

    /** @test */
    public function it_includes_the_ability_to_filter_records_by_fields()
    {
        $this->assertTrue(in_array(
            FiltersRecordsByFields::class,
            class_uses(TestQuestion::class)
        ));
    }
}

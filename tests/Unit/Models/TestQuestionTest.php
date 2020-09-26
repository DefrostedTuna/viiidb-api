<?php

namespace Tests\Unit\Models;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestQuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table()
    {
        $testQuestion = new TestQuestion();
    
        $this->assertEquals('test_questions', $testQuestion->getTable());
    }
    
    /** @test */
    public function it_sets_the_primary_key_type_to_string()
    {
        $testQuestion = new TestQuestion();
    
        $this->assertEquals('string', $testQuestion->getKeyType());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name()
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('id', $testQuestion->getRouteKeyName());
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
            'seed_test_id',
            'question_number',
            'question',
            'answer',
            'test',
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
            'id'                => 'string',
            'seed_test_id'      => 'string',
            'question_number'   => 'integer',
            'question'          => 'string',
            'answer'            => 'string',
        ];
    
        $this->assertEquals($expected, $fields);
    }
    
    /** @test */
    public function it_is_able_to_filter_records()
    {
        $this->assertTrue(in_array(
            Filterable::class,
            class_uses(TestQuestion::class)
        ));
    }
    
    /** @test */
    public function it_allows_specific_fields_to_be_filtered()
    {
        $testQuestion = new TestQuestion();
        $shouldBeFilterable = [
            'question_number',
            'question',
            'answer',
        ];
    
        $this->assertEquals($shouldBeFilterable, $testQuestion->getFilterableFields());
    }
    
    /** @test */
    public function it_orders_results_by_question_number()
    {
        $testQuestion = new TestQuestion();
    
        $this->assertEquals('question_number', $testQuestion->getOrderByField());
    }
    
    /** @test */
    public function it_explicitly_defines_the_order_results_should_be_returned_by()
    {
        $testQuestion = new TestQuestion();
    
        $this->assertEquals('asc', $testQuestion->getOrderByDirection());
    }

    /** @test */
    public function it_defines_the_relations_associated_with_the_model()
    {
        $testQuestion = new TestQuestion();

        // Seed Test.
        $this->assertInstanceOf(BelongsTo::class, $testQuestion->test());
        $this->assertInstanceOf(SeedTest::class, $testQuestion->test()->getRelated());
    }

    /** @test */
    public function it_explicitly_defines_the_relations_to_be_loaded_through_filters()
    {
        $testQuestion = new TestQuestion();

        $expected = [
            'test',
        ];
    
        $this->assertEquals($expected, $testQuestion->getValidRelations());
    }
}

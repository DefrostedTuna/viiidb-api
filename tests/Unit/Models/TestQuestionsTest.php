<?php

namespace Tests\Unit\Models;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class TestQuestionsTest extends TestCase
{
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
    public function it_casts_the_seed_test_id_column_to_a_string()
    {
        $testQuestion = new TestQuestion();
        $casts = $testQuestion->getCasts();

        $this->assertArrayHasKey('seed_test_id', $casts);
        $this->assertEquals('string', $casts['seed_test_id']);
    }

    /** @test */
    public function it_casts_the_question_number_column_to_an_integer()
    {
        $testQuestion = new TestQuestion();
        $casts = $testQuestion->getCasts();

        $this->assertArrayHasKey('question_number', $casts);
        $this->assertEquals('integer', $casts['question_number']);
    }

    /** @test */
    public function it_casts_the_question_column_to_a_string()
    {
        $testQuestion = new TestQuestion();
        $casts = $testQuestion->getCasts();

        $this->assertArrayHasKey('question', $casts);
        $this->assertEquals('string', $casts['question']);
    }

    /** @test */
    public function it_casts_the_answer_column_to_a_string()
    {
        $testQuestion = new TestQuestion();
        $casts = $testQuestion->getCasts();

        $this->assertArrayHasKey('answer', $casts);
        $this->assertEquals('string', $casts['answer']);
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
    public function it_allows_the_test_to_be_loaded_through_filters()
    {
        $testQuestion = new TestQuestion();

        $this->assertContains('test', $testQuestion->getValidRelations());
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
    public function it_can_belong_to_a_seed_test()
    {
        $testQuestion = new TestQuestion();

        $this->assertInstanceOf(BelongsTo::class, $testQuestion->test());
        $this->assertInstanceOf(SeedTest::class, $testQuestion->test()->getRelated());
    }
}

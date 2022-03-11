<?php

namespace Tests\Unit\Models;

use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestCase;

class TestQuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_the_proper_database_table(): void
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('test_questions', $testQuestion->getTable());
    }

    /** @test */
    public function it_explicitly_defines_the_column_that_results_should_use_for_ordering(): void
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('sort_id', $testQuestion->getOrderByField());
    }

    /** @test */
    public function it_explicitly_defines_the_visible_fields_for_api_consumption(): void
    {
        $testQuestion = new TestQuestion();

        $visibleFields = [
            'id',
            'sort_id',
            'seed_test_id',
            'question_number',
            'question',
            'answer',
            'seedTest',
        ];

        $this->assertEquals($visibleFields, $testQuestion->getVisible());
    }

    /** @test */
    public function it_explicitly_defines_the_cast_type_for_each_field(): void
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
    public function it_explicitly_defines_the_fields_that_are_searchable(): void
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
    public function it_explicitly_defines_the_fields_that_are_filterable(): void
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
    public function it_explicitly_defines_the_relations_that_are_available_to_include_with_the_resource(): void
    {
        $testQuestion = new TestQuestion();

        $expected = [
            'seedTest',
        ];

        $this->assertEquals($expected, $testQuestion->getAvailableIncludes());
    }

    /** @test */
    public function it_explicitly_defines_the_default_relations_to_include_with_the_resource(): void
    {
        $testQuestion = new TestQuestion();

        $expected = [];

        $this->assertEquals($expected, $testQuestion->getDefaultIncludes());
    }

    /** @test */
    public function it_explicitly_defines_the_route_key_name(): void
    {
        $testQuestion = new TestQuestion();

        $this->assertEquals('id', $testQuestion->getRouteKeyName());
    }
}

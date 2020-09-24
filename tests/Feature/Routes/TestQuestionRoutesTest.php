<?php

namespace Tests\Feature\Routes;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestQuestionRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_test_questions()
    {
        $testQuestions = TestQuestion::factory()->count(10)->create();

        $response = $this->get('/api/test-questions');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_test_question()
    {
        $testQuestion = TestQuestion::factory()->create();

        $response = $this->get("/api/test-questions/{$testQuestion->id}");

        $response->assertStatus(200);
        $response->assertJson($testQuestion->toArray());
    }

    /** @test */
    public function it_can_load_relations_on_individual_records()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 5,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $response = $this->get("/api/test-questions/{$testQuestion->id}?with=test");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'test' => $seedTest->toArray(),
        ]);
    }

    /** @test */
    public function it_can_load_relation_properties_on_individual_records()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 5,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $response = $this->get("/api/test-questions/{$testQuestion->id}?with=test.level");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'test' => [
                'id' => $seedTest->id,
                'level' => $seedTest->level,
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/test-questions/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function the_filters_are_case_insensitive()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question=like:YoUr');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_equals_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_lt_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=lt:3');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 2 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_lte_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=lte:2');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 2 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_gt_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=gt:2');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_gte_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=gte:2');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 2 ]);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_like_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 10,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=like:1');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 10 ]);
    }

    /** @test */
    public function the_question_number_column_can_be_filtered_by_the_not_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question_number=not:3');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 2 ]);
    }

    /** @test */
    public function the_question_column_can_be_filtered_by_the_equals_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question=What is your quest?');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_question_column_can_be_filtered_by_the_like_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question=like:your');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_question_column_can_be_filtered_by_the_not_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?question=not:What is your quest?');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 2 ]);
    }

    /** @test */
    public function the_answer_column_can_be_filtered_by_the_equals_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?answer=yes');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_answer_column_can_be_filtered_by_the_like_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?answer=like:ye');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'question_number' => 1 ]);
        $response->assertJsonFragment([ 'question_number' => 3 ]);
    }

    /** @test */
    public function the_answer_column_can_be_filtered_by_the_not_operator()
    {
        TestQuestion::factory()->create([
            'question_number' => 1,
            'question' => 'What is your favorite color?',
            'answer' => 'yes',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 2,
            'question' => 'What Is the airspeed velocity of an unladen swallow?',
            'answer' => 'no',
        ]);
        TestQuestion::factory()->create([
            'question_number' => 3,
            'question' => 'What is your quest?',
            'answer' => 'yes',
        ]);

        $response = $this->get('/api/test-questions?answer=not:yes');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'question_number' => 2 ]);
    }

    /** @test */
    public function it_can_load_the_test_without_additional_filters()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 5,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $response = $this->get("/api/test-questions?with=test");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'test' => $seedTest->toArray(),
        ]);
    }

    /** @test */
    public function it_can_load_the_level_column_on_the_test_relation()
    {
        $seedTest = SeedTest::factory()->create([
            'level' => 5,
        ]);
        $testQuestion = TestQuestion::factory()->create([
            'seed_test_id' => $seedTest->id,
            'question_number' => 1,
            'question' => 'Will this work?',
            'answer' => 'yes',
        ]);

        $response = $this->get("/api/test-questions/{$testQuestion->id}?with=test.level");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'test' => $seedTest->toArray(),
        ]);
    }
}

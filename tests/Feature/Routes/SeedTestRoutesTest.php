<?php

namespace Tests\Feature\Routes;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedTestRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_return_a_list_of_seed_tests()
    {
        $seedTests = SeedTest::factory()->count(10)->create();

        $response = $this->get('/api/seed-tests');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_seed_test()
    {
        $seedTest = SeedTest::factory()->create();

        $response = $this->get("/api/seed-tests/{$seedTest->id}");

        $response->assertStatus(200);
        $response->assertJson($seedTest->toArray());
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

        $response = $this->get("/api/seed-tests/{$seedTest->id}?with=questions");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                $testQuestion->toArray(),
            ]
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

        $response = $this->get("/api/seed-tests/{$seedTest->id}?with=questions.question_number");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $seedTest->id,
                    'question_number' => $testQuestion->question_number,
                ]
            ],
        ]);
    }

    /** @test */
    public function it_can_load_multiple_relation_properties_on_individual_records()
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

        $response = $this->get("/api/seed-tests/{$seedTest->id}?with=questions.question_number,questions.question");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $seedTest->id,
                    'question_number' => $testQuestion->question_number,
                    'question' => $testQuestion->question,
                ]
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/seed-tests/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function the_level_column_can_be_filtered_by_the_equals_operator()
    {
        SeedTest::factory()->create([ 'level' => 1 ]);
        SeedTest::factory()->create([ 'level' => 5 ]);
        SeedTest::factory()->create([ 'level' => 10 ]);

        $response = $this->get('/api/seed-tests?level=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'level' => 1 ]);
    }

    /** @test */
    public function the_level_column_can_be_filtered_by_the_like_operator()
    {
        SeedTest::factory()->create([ 'level' => 1 ]);
        SeedTest::factory()->create([ 'level' => 5 ]);
        SeedTest::factory()->create([ 'level' => 10 ]);

        $response = $this->get('/api/seed-tests?level=like:1');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'level' => 1 ]);
        $response->assertJsonFragment([ 'level' => 10 ]);
    }

    /** @test */
    public function the_level_column_can_be_filtered_by_the_not_operator()
    {
        SeedTest::factory()->create([ 'level' => 1 ]);
        SeedTest::factory()->create([ 'level' => 5 ]);
        SeedTest::factory()->create([ 'level' => 10 ]);

        $response = $this->get('/api/seed-tests?level=not:10');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'level' => 1 ]);
        $response->assertJsonFragment([ 'level' => 5 ]);
    }

    /** @test */
    public function it_can_load_the_questions_without_additional_filters()
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

        $response = $this->get("/api/seed-tests?with=questions");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                $testQuestion->toArray(),
            ],
        ]);
    }

    /** @test */
    public function it_can_load_the_question_number_column_on_the_questions_relation()
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

        $response = $this->get("/api/seed-tests?with=questions.question_number");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $seedTest->id,
                    'question_number' => $testQuestion->question_number,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_load_the_question_column_on_the_questions_relation()
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

        $response = $this->get("/api/seed-tests/{$seedTest->id}?with=questions.question");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $seedTest->id,
                    'question' => $testQuestion->question,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_load_the_answer_column_on_the_questions_relation()
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

        $response = $this->get("/api/seed-tests/{$seedTest->id}?with=questions.answer");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $seedTest->id,
                    'answer' => $testQuestion->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_load_multiple_relation_columns_explicitly()
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

        $response = $this->get("/api/seed-tests/{$seedTest->id}?with=questions.question_number,questions.question");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $seedTest->id,
                    'question_number' => $testQuestion->question_number,
                    'question' => $testQuestion->question,
                ]
            ],
        ]);
    }
}

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
    public function it_will_return_a_list_of_seed_tests()
    {
        SeedTest::factory()->count(10)->create();

        $response = $this->get('/api/seed-tests');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_will_return_an_individual_seedTest()
    {
        $seedTest = SeedTest::factory()->create();

        $response = $this->get("/api/seed-tests/{$seedTest->level}");

        $response->assertStatus(200);
        $response->assertJson($seedTest->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/seed-tests/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_filter_seed_tests_by_the_level_column()
    {
        SeedTest::factory()->create([ 'level' => 1 ]);
        SeedTest::factory()->create([ 'level' => 5 ]);
        SeedTest::factory()->create([ 'level' => 10 ]);

        // Equals
        $response = $this->get('/api/seed-tests?level=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'level' => 1 ]);

        // Less Than
        $response = $this->get('/api/seed-tests?level=lt:5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'level' =>  1]);

        // Less Than or Equal To
        $response = $this->get('/api/seed-tests?level=lte:5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'level' => 1 ]);
        $response->assertJsonFragment([ 'level' => 5 ]);

        // Greater Than
        $response = $this->get('/api/seed-tests?level=gt:5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'level' => 10 ]);

        // Greater Than or Equal To
        $response = $this->get('/api/seed-tests?level=gte:5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'level' => 5 ]);
        $response->assertJsonFragment([ 'level' => 10 ]);
        ;

        // Like
        $response = $this->get('/api/seed-tests?level=like:1');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'level' => 1 ]);
        $response->assertJsonFragment([ 'level' => 10 ]);

        // Not
        $response = $this->get('/api/seed-tests?level=not:10');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'level' => 1 ]);
        $response->assertJsonFragment([ 'level' => 5 ]);
    }

    /** @test */
    public function it_can_load_relations_on_a_list_of_resources()
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

        $response = $this->get('/api/seed-tests?with=questions');
        $response->assertStatus(200);
        $response->assertJsonCount(1);

        // Test Question.
        $response->assertJsonFragment([
            'questions' => [ $testQuestion->toArray() ],
        ]);
    }

    /** @test */
    public function it_can_load_relations_on_an_individual_resource()
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

        $response = $this->get('/api/seed-tests/5?with=questions');
        $response->assertStatus(200);

        // Test Question.
        $response->assertJsonFragment([
            'questions' => [ $testQuestion->toArray() ],
        ]);
    }

    /** @test */
    public function it_can_load_relation_properties_on_a_list_of_resources()
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

        $response = $this->get('/api/seed-tests?with=questions.question_number,questions.question,questions.answer');
        $response->assertStatus(200);
        $response->assertJsonCount(1);

        // Test Question.
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $testQuestion->seed_test_id,
                    'question_number' => $testQuestion->question_number,
                    'question' => $testQuestion->question,
                    'answer' => $testQuestion->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_load_relation_properties_on_an_individual_resource()
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

        $response = $this->get('/api/seed-tests/5?with=questions.question_number,questions.question,questions.answer');
        $response->assertStatus(200);

        // Test Question.
        $response->assertJsonFragment([
            'questions' => [
                [
                    'id' => $testQuestion->id,
                    'seed_test_id' => $testQuestion->seed_test_id,
                    'question_number' => $testQuestion->question_number,
                    'question' => $testQuestion->question,
                    'answer' => $testQuestion->answer,
                ],
            ],
        ]);
    }
}

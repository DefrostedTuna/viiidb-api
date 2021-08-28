<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestQuestionEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions()
    {
        $testQuestions = TestQuestion::factory()->count(10)->create();

        $response = $this->get('/v0/test-questions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data',
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_will_return_an_individual_test_question_using_the_id_key()
    {
        $testQuestion = TestQuestion::factory()->create();

        $response = $this->get("/v0/test-questions/{$testQuestion->id}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $testQuestion->id,
                'sort_id' => $testQuestion->sort_id,
                'seed_test_id' => $testQuestion->seed_test_id,
                'question_number' => $testQuestion->question_number,
                'question' => $testQuestion->question,
                'answer' => $testQuestion->answer,
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/v0/test-questions/invalid');

        $response->assertStatus(404);
        $response->assertExactJson([
            'success' => false,
            'message' => 'The requested record could not be found.',
            'status_code' => 404,
            'errors' => [
                'message' => 'The requested record could not be found.',
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_question_number_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?search=1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_question_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?search=can');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_answer_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?search=false');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_number_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?question_number=1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_number_column_using_the_like_statement()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?question_number=like:1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get("/v0/test-questions?question=Potions can restore a GF's HP.");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_column_using_the_like_statement()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?question=like:can');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_answer_column()
    {
        TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        $two = TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?answer=true');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'seed_test_id' => $two->seed_test_id,
                    'question_number' => $two->question_number,
                    'question' => $two->question,
                    'answer' => $two->answer,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_answer_column_using_the_like_statement()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $response = $this->get('/v0/test-questions?answer=like:f');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ]);
    }
}

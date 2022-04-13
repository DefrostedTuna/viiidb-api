<?php

namespace Tests\Feature\Endpoints\V0;

use App\Http\Transformers\V0\SeedTestTransformer;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestQuestionEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions(): void
    {
        TestQuestion::factory()->count(10)->create();

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
    public function it_will_return_an_individual_test_question_using_the_id_key(): void
    {
        $testQuestion = TestQuestion::factory()->create()->toArray();

        $response = $this->get("/v0/test-questions/{$testQuestion['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $testQuestion['id'],
                'sort_id' => $testQuestion['sort_id'],
                'seed_test_id' => $testQuestion['seed_test_id'],
                'question_number' => $testQuestion['question_number'],
                'question' => $testQuestion['question'],
                'answer' => $testQuestion['answer'],
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
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
    public function it_can_load_the_seed_test_relation_on_a_list_of_test_questions(): void
    {
        TestQuestion::factory()
            ->count(10)
            ->for(SeedTest::factory())
            ->create();

        $response = $this->get('/v0/test-questions?include=seed-test');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'seed_test' => [
                        // An array of SeeD Test data on each record...
                    ],
                ],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_can_load_the_seed_test_relation_on_an_individual_test_question(): void
    {
        $testQuestion = TestQuestion::factory()
            ->for(SeedTest::factory())
            ->create()
            ->load('seedTest')
            ->toArray();

        $seedTestTransformer = $this->app->make(SeedTestTransformer::class);
        $response = $this->get("/v0/test-questions/{$testQuestion['id']}?include=seed-test");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $testQuestion['id'],
                'sort_id' => $testQuestion['sort_id'],
                'seed_test_id' => $testQuestion['seed_test_id'],
                'question_number' => $testQuestion['question_number'],
                'question' => $testQuestion['question'],
                'answer' => $testQuestion['answer'],
                'seed_test' => $seedTestTransformer->transformRecord($testQuestion['seed_test']),
            ],
        ]);
    }
}

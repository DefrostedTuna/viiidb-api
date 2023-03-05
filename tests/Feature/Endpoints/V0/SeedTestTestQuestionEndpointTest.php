<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedTestTestQuestionEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions_related_to_a_seed_test_using_the_id_key(): void
    {
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(10))
            ->create()
            ->toArray();

        $response = $this->get("/v0/seed-tests/{$seedTest['id']}/test-questions");

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
    public function it_will_return_a_list_of_test_questions_related_to_a_seed_test_using_the_level_key(): void
    {
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(10))
            ->create()
            ->toArray();

        $response = $this->get("/v0/seed-tests/{$seedTest['level']}/test-questions");

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
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/seed-tests/invalid/test-questions');

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
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(10))
            ->create()
            ->toArray();

        $response = $this->get("/v0/seed-tests/{$seedTest['id']}/test-questions?include=seed-test");

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
}

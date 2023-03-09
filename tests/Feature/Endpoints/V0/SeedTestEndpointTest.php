<?php

namespace Tests\Feature\Endpoints\V0;

use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class SeedTestEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The middleware to exclude when running tests.
     *
     * @var array<int, class-string>
     */
    protected $excludedMiddlware = [
        ThrottleRequestsWithRedis::class,
    ];

    /** @test */
    public function it_will_return_a_list_of_seed_tests(): void
    {
        SeedTest::factory()->count(10)->create();

        $response = $this->get('/v0/seed-tests');

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
    public function it_will_return_an_individual_seed_test_using_the_id_key(): void
    {
        $seedTest = SeedTest::factory()->create()->toArray();

        $response = $this->get("/v0/seed-tests/{$seedTest['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest['id'],
                'level' => $seedTest['level'],
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_level_key(): void
    {
        $seedTest = SeedTest::factory()->create()->toArray();

        $response = $this->get("/v0/seed-tests/{$seedTest['level']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest['id'],
                'level' => $seedTest['level'],
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/seed-tests/invalid');

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
    public function it_can_load_the_test_questions_relation_on_a_list_of_seed_tests(): void
    {
        SeedTest::factory()
            ->count(10)
            ->has(TestQuestion::factory()->count(10))
            ->create();

        $response = $this->get('/v0/seed-tests?include=test-questions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                [
                    'test_questions' => [
                        // An array of Test Questions on each record...
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
    public function it_can_load_the_test_questions_relation_on_an_individual_seed_test(): void
    {
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(1))
            ->create()
            ->load('testQuestions')
            ->toArray();

        $testQuestionTransformer = $this->app->make(TestQuestionTransformer::class);
        $response = $this->get("/v0/seed-tests/{$seedTest['id']}?include=test-questions");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest['id'],
                'level' => $seedTest['level'],
                'test_questions' => $testQuestionTransformer->transformCollection($seedTest['test_questions']),
            ],
        ]);
    }
}

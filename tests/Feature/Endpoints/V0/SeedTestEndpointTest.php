<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\SeedTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedTestEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_tests()
    {
        $seedTests = SeedTest::factory()->count(10)->create();

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
    public function it_will_return_an_individual_seed_test_using_the_id_key()
    {
        $seedTest = SeedTest::factory()->create();

        $response = $this->get("/v0/seed-tests/{$seedTest->id}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest->id,
                'level' => $seedTest->level,
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_level_key()
    {
        $seedTest = SeedTest::factory()->create();

        $response = $this->get("/v0/seed-tests/{$seedTest->level}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest->id,
                'level' => $seedTest->level,
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
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
    public function it_can_search_for_seed_tests_via_the_level_column()
    {
        $one = SeedTest::factory()->create(['level' => 1]);
        SeedTest::factory()->create(['level' => 5]);
        $three = SeedTest::factory()->create(['level' => 10]);

        $response = $this->get('/v0/seed-tests?search=1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'level' => $one->level,
                ],
                [
                    'id' => $three->id,
                    'level' => $three->level,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_seed_tests_via_the_level_column()
    {
        $one = SeedTest::factory()->create(['level' => 1]);
        SeedTest::factory()->create(['level' => 5]);
        SeedTest::factory()->create(['level' => 10]);

        $response = $this->get('/v0/seed-tests?level=1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'level' => $one->level,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_filter_seed_tests_via_the_level_column_using_the_like_statement()
    {
        $one = SeedTest::factory()->create(['level' => 1]);
        SeedTest::factory()->create(['level' => 5]);
        $three = SeedTest::factory()->create(['level' => 10]);

        $response = $this->get('/v0/seed-tests?level=like:1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'level' => $one->level,
                ],
                [
                    'id' => $three->id,
                    'level' => $three->level,
                ],
            ],
        ]);
    }
}

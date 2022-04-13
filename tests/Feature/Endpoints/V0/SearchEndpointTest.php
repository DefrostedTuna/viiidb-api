<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\SeedRank;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_search_for_records(): void
    {
        // Scout is disabled during testing, so search queries won't hit the actual service.
        // Fallback SQL queries return slightly different results; `query%` vs `%query%`.
        SeedRank::factory(3)->sequence(
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 15, 'salary' => 12500],
        )->create()->toArray();

        $response = $this->get('/v0/search?q=1000');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(2, 'data.seed_ranks');
    }

    /** @test */
    public function it_will_search_for_records_within_a_subset_of_resources(): void
    {
        // Scout is disabled during testing, so search queries won't hit the actual service.
        // Fallback SQL queries return slightly different results; `query%` vs `%query%`.
        SeedRank::factory(3)->sequence(
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 15, 'salary' => 12500],
        )->create();
        TestQuestion::factory(5)->create();

        $response = $this->get('/v0/search?q=1000&only=seed-ranks');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(2, 'data.seed_ranks');
    }

    /** @test */
    public function it_will_exclude_a_subset_of_resources_when_searching_for_records(): void
    {
        // Scout is disabled during testing, so search queries won't hit the actual service.
        // Fallback SQL queries return slightly different results; `query%` vs `%query%`.
        SeedRank::factory(3)->sequence(
            ['rank' => 2, 'salary' => 1000],
            ['rank' => 12, 'salary' => 10000],
            ['rank' => 15, 'salary' => 12500],
        )->create();
        TestQuestion::factory(5)->create();

        $response = $this->get('/v0/search?q=1000&exclude=test-questions');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'status_code',
            'data' => [
                'seed_ranks' => [],
            ],
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ]);
        $response->assertJsonCount(2, 'data.seed_ranks');
    }
}

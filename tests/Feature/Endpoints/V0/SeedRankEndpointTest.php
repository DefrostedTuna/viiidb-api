<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedRankEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_ranks(): void
    {
        SeedRank::factory()->count(10)->create();

        $response = $this->get('/v0/seed-ranks');

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
    public function it_will_return_an_individual_seed_rank_using_the_id_key(): void
    {
        $seedRank = SeedRank::factory()->create()->toArray();

        $response = $this->get("/v0/seed-ranks/{$seedRank['id']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedRank['id'],
                'rank' => $seedRank['rank'],
                'salary' => $seedRank['salary'],
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_rank_key(): void
    {
        $seedRank = SeedRank::factory()->create()->toArray();

        $response = $this->get("/v0/seed-ranks/{$seedRank['rank']}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedRank['id'],
                'rank' => $seedRank['rank'],
                'salary' => $seedRank['salary'],
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $response = $this->get('/v0/seed-ranks/invalid');

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
}

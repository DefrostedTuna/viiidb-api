<?php

namespace Tests\Feature\Endpoints\V0;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedRankEndpointTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_ranks()
    {
        $seedRanks = SeedRank::factory()->count(10)->create();

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
    public function it_will_return_an_individual_seed_rank_using_the_id_key()
    {
        $seedRank = SeedRank::factory()->create();

        $response = $this->get("/v0/seed-ranks/{$seedRank->id}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedRank->id,
                'rank' => $seedRank->rank,
                'salary' => $seedRank->salary,
            ],
        ]);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_rank_key()
    {
        $seedRank = SeedRank::factory()->create();

        $response = $this->get("/v0/seed-ranks/{$seedRank->rank}");

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedRank->id,
                'rank' => $seedRank->rank,
                'salary' => $seedRank->salary,
            ],
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
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

    /** @test */
    public function it_can_search_for_seed_ranks_via_the_rank_column()
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500]);
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        $three = SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $response = $this->get('/v0/seed-ranks?search=1');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'rank' => $one->rank,
                    'salary' => $one->salary,
                ],
                [
                    'id' => $three->id,
                    'rank' => $three->rank,
                    'salary' => $three->salary,
                ],
            ],
        ]);
    }

    /** @test */
    public function it_can_search_for_seed_ranks_via_the_salary_column()
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500]);
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $response = $this->get('/v0/seed-ranks?search=500');

        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'rank' => $one->rank,
                    'salary' => $one->salary,
                ],
            ],
        ]);
    }
}

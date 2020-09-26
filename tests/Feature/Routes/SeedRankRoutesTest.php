<?php

namespace Tests\Feature\Routes;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedRankRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_ranks()
    {
        SeedRank::factory()->count(10)->create();

        $response = $this->get('/api/seed-ranks');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank()
    {
        $seedRank = SeedRank::factory()->create();

        $response = $this->get("/api/seed-ranks/{$seedRank->rank}");

        $response->assertStatus(200);
        $response->assertJson($seedRank->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/seed-ranks/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_filter_seed_rank_by_the_rank_column()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        // Equals
        $response = $this->get('/api/seed-ranks?rank=5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'rank' => 5 ]);

        // Less Than
        $response = $this->get('/api/seed-ranks?rank=lt:5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'rank' => 1 ]);

        // Less Than or Equal To
        $response = $this->get('/api/seed-ranks?rank=lte:5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => 1 ]);
        $response->assertJsonFragment([ 'rank' => 5 ]);

        // Greater Than
        $response = $this->get('/api/seed-ranks?rank=gt:5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'rank' => 10 ]);

        // Greater Than or Equal To
        $response = $this->get('/api/seed-ranks?rank=gte:5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => 5 ]);
        $response->assertJsonFragment([ 'rank' => 10 ]);

        // Like
        $response = $this->get('/api/seed-ranks?rank=like:1');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => 1 ]);
        $response->assertJsonFragment([ 'rank' => 10 ]);

        // Not
        $response = $this->get('/api/seed-ranks?rank=not:10');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => 1 ]);
        $response->assertJsonFragment([ 'rank' => 5 ]);
    }

    /** @test */
    public function it_can_filter_seed_ranks_by_the_salary_column()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        // Equals
        $response = $this->get('/api/seed-ranks?salary=3000');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'salary' => 3000 ]);

        // Less Than
        $response = $this->get('/api/seed-ranks?salary=lt:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'salary' => 500 ]);

        // Less Than or Equal To
        $response = $this->get('/api/seed-ranks?salary=lte:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 500 ]);
        $response->assertJsonFragment([ 'salary' => 3000 ]);

        // Greater Than
        $response = $this->get('/api/seed-ranks?salary=gt:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'salary' => 8000 ]);

        // Greater Than or Equal To
        $response = $this->get('/api/seed-ranks?salary=gte:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
        $response->assertJsonFragment([ 'salary' => 8000 ]);

        // Like
        $response = $this->get('/api/seed-ranks?salary=like:000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
        $response->assertJsonFragment([ 'salary' => 8000 ]);

        // Not
        $response = $this->get('/api/seed-ranks?salary=not:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 500 ]);
        $response->assertJsonFragment([ 'salary' => 8000 ]);
    }
}

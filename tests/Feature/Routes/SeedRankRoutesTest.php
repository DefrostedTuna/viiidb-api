<?php

namespace Tests\Feature\Routes;

use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedRankRoutesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_seed_ranks()
    {
        $seedRanks = SeedRank::factory()->count(10)->create();

        $response = $this->get('/api/seed-ranks');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /** @test */
    public function it_returns_an_individual_seed_rank()
    {
        $seedRank = SeedRank::factory()->create();

        $response = $this->get("/api/seed-ranks/{$seedRank->id}");

        $response->assertStatus(200);
        $response->assertJson($seedRank->toArray());
    }

    /** @test */
    public function it_throws_an_exception_when_an_individual_record_is_not_found()
    {
        $response = $this->get('/api/seed-ranks/invalid');

        $response->assertStatus(404);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_equals_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'rank' => '5' ]);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_gt_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=gt:5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'rank' => '10' ]);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_gte_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=gte:5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => '5' ]);
        $response->assertJsonFragment([ 'rank' => '10' ]);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_lt_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=lt:5');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'rank' => '1' ]);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_lte_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=lte:5');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => '1' ]);
        $response->assertJsonFragment([ 'rank' => '5' ]);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_like_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=like:1');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => '1' ]);
        $response->assertJsonFragment([ 'rank' => '10' ]);
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_not_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1 ]);
        SeedRank::factory()->create([ 'rank' => 5 ]);
        SeedRank::factory()->create([ 'rank' => 10 ]);

        $response = $this->get('/api/seed-ranks?rank=not:10');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'rank' => '1' ]);
        $response->assertJsonFragment([ 'rank' => '5' ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_equals_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=3000');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_gt_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=gt:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'salary' => 8000 ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_gte_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=gte:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
        $response->assertJsonFragment([ 'salary' => 8000 ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_lt_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=lt:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([ 'salary' => 500 ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_lte_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=lte:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 500 ]);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_like_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=like:000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
        $response->assertJsonFragment([ 'salary' => 8000 ]);
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_not_operator()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=not:3000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 500 ]);
        $response->assertJsonFragment([ 'salary' => 8000 ]);
    }

    /** @test */
    public function the_name_and_salary_columns_can_both_be_filtered_together()
    {
        SeedRank::factory()->create([ 'rank' => 1, 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => 5, 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => 10, 'salary' => 8000 ]);

        $response = $this->get('/api/seed-ranks?salary=not:8000');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
        $response->assertJsonFragment([ 'salary' => 500 ]);
        $response->assertJsonFragment([ 'salary' => 3000 ]);
    }
}

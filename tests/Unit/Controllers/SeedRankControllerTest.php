<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SeedRankController;
use App\Models\SeedRank;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SeedRankControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_a_list_of_seed_ranks()
    {
        $seedRanks = factory(SeedRank::class, 10)->create();

        $seedRankController = new SeedRankController(new SeedRank);

        $response = $seedRankController->index(new Request());

        // Controller should return a collection of Seed Ranks.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_returns_an_individual_seed_rank()
    {
        $seedRank = factory(SeedRank::class)->create();

        $seedRankController = new SeedRankController(new SeedRank);

        $response = $seedRankController->show(new Request(), $seedRank);

        // The controller should return the instance of a Seed Rank that was found via 
        // route model binding. Since we are mocking this result by injecting the
        // Seed Rank into the method, we should get the same Seed Rank back.
        $this->assertInstanceOf(SeedRank::class, $response);
        $this->assertEquals($seedRank, $response);
    }

    /** @test */
    public function multiple_colons_will_be_ignored_when_filtering_results()
    {
        // Set the filterable operators on the SeedRank class.
        $seedRank = new SeedRank();
        $seedRank->filterableOperators = ['like' => 'like'];

        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => "like:1:0"]);
        $seedRankController = new SeedRankController($seedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', 1));
        $this->assertTrue($response->contains('rank', 10));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_equals_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 5]);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('rank', 5));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_gt_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 'gt:5']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('rank', 10));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_gte_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 'gte:5']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', 5));
        $this->assertTrue($response->contains('rank', 10));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_lt_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 'lt:5']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('rank', 1));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_lte_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 'lte:5']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', 1));
        $this->assertTrue($response->contains('rank', 5));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_like_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 'like:1']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', 1));
        $this->assertTrue($response->contains('rank', 10));
    }

    /** @test */
    public function the_rank_column_can_be_filtered_by_the_not_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1 ]);
        factory(SeedRank::class)->create([ 'rank' => 5 ]);
        factory(SeedRank::class)->create([ 'rank' => 10 ]);

        $request = new Request(['rank' => 'not:10']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', 1));
        $this->assertTrue($response->contains('rank', 5));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_equals_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 500]);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 500));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_gt_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 'gt:3000']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 8000));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_gte_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 'gte:3000']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 3000));
        $this->assertTrue($response->contains('salary', 8000));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_lt_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 'lt:3000']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 500));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_lte_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 'lte:3000']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 500));
        $this->assertTrue($response->contains('salary', 3000));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_like_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 'like:000']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 3000));
        $this->assertTrue($response->contains('salary', 8000));
    }

    /** @test */
    public function the_salary_column_can_be_filtered_by_the_not_operator()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request(['salary' => 'not:8000']);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 500));
        $this->assertTrue($response->contains('salary', 3000));
    }

    /** @test */
    public function the_name_and_salary_columns_can_both_be_filtered_together()
    {
        factory(SeedRank::class)->create([ 'rank' => 1, 'salary' => 500 ]);
        factory(SeedRank::class)->create([ 'rank' => 5, 'salary' =>  3000 ]);
        factory(SeedRank::class)->create([ 'rank' => 10, 'salary' => 8000 ]);

        $request = new Request([
            'rank' => 'like:1',
            'salary' => 'like:000',
        ]);
        $seedRankController = new SeedRankController(new SeedRank);
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 8000));
    }
}
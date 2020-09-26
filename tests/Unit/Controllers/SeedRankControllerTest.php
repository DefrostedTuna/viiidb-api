<?php

namespace Tests\Unit\Controllers;

use App\Http\Controllers\SeedRankController;
use App\Models\SeedRank;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SeedRankControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_ranks()
    {
        $seed_ranks = SeedRank::factory()->count(10)->create();

        $seedRankController = new SeedRankController(new SeedRank());

        $response = $seedRankController->index(new Request());

        // Controller should return a collection of SeedRanks.
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(10, $response);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank()
    {
        $seedRank = SeedRank::factory()->create();

        $seedRankController = new SeedRankController(new SeedRank());

        $response = $seedRankController->show(new Request(), $seedRank->rank);

        // The controller should return the instance of an SeedRank that was found via
        // route model binding. Since we are mocking this result by injecting the
        // SeedRank into the method, we should get the same SeedRank back.
        $this->assertInstanceOf(SeedRank::class, $response);
        $this->assertEquals($seedRank->toArray(), $response->toArray());
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $seedRankController = new SeedRankController(new SeedRank());

        $seedRankController->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_filter_seed_ranks_by_the_rank_column()
    {
        SeedRank::factory()->create([ 'rank' => '1' ]);
        SeedRank::factory()->create([ 'rank' => '5' ]);
        SeedRank::factory()->create([ 'rank' => '10' ]);

        // Equals
        $request = new Request([ 'rank' => '5' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('rank', '5'));

        // Less Than
        $request = new Request([ 'rank' => 'lt:5' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('rank', '1'));

        // Less Than or Equal To
        $request = new Request([ 'rank' => 'lte:5' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', '1'));
        $this->assertTrue($response->contains('rank', '5'));

        // Greater Than
        $request = new Request([ 'rank' => 'gt:5' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('rank', '10'));

        // Greater Than or Equal To
        $request = new Request([ 'rank' => 'gte:5' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', '5'));
        $this->assertTrue($response->contains('rank', '10'));

        // Like
        $request = new Request([ 'rank' => 'like:1' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', '1'));
        $this->assertTrue($response->contains('rank', '10'));

        // Not
        $request = new Request([ 'rank' => 'not:10' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('rank', '1'));
        $this->assertTrue($response->contains('rank', '5'));
    }

    /** @test */
    public function it_can_filter_seed_ranks_by_the_salary_column()
    {
        SeedRank::factory()->create([ 'rank' => '1', 'salary' => 500 ]);
        SeedRank::factory()->create([ 'rank' => '5', 'salary' =>  3000 ]);
        SeedRank::factory()->create([ 'rank' => '10', 'salary' => 8000 ]);

        // Equals
        $request = new Request([ 'salary' => 500 ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 500));

        // Less Than
        $request = new Request([ 'salary' => 'lt:3000' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 500));

        // Less Than or Equal To
        $request = new Request([ 'salary' => 'lte:3000' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 500));
        $this->assertTrue($response->contains('salary', 3000));

        // Greater Than
        $request = new Request([ 'salary' => 'gt:3000' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);

        $this->assertCount(1, $response);
        $this->assertTrue($response->contains('salary', 8000));

        // Greater Than or Equal To
        $request = new Request([ 'salary' => 'gte:3000' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 3000));
        $this->assertTrue($response->contains('salary', 8000));

        // Like
        $request = new Request([ 'salary' => 'like:000' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 3000));
        $this->assertTrue($response->contains('salary', 8000));

        // Not
        $request = new Request([ 'salary' => 'not:8000' ]);
        $seedRankController = new SeedRankController(new SeedRank());
        $response = $seedRankController->index($request);
        $this->assertCount(2, $response);
        $this->assertTrue($response->contains('salary', 500));
        $this->assertTrue($response->contains('salary', 3000));
    }
}

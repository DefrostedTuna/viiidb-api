<?php

namespace Tests\Unit\Controllers\V0;

use App\Contracts\Services\SeedRankService;
use App\Http\Controllers\V0\SeedRankController;
use App\Http\Transformers\V0\SeedRankTransformer;
use App\Models\SeedRank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class SeedRankControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_ranks(): void
    {
        SeedRank::factory()->count(10)->create();

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request());

        $this->assertArraySubset([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ], $response->getData(true));
        $this->assertCount(10, $response->getData(true)['data']);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_id_key(): void
    {
        $seedRank = SeedRank::factory()->create()->toArray();

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->show(new Request(), $seedRank['id']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedRank['id'],
                'rank' => $seedRank['rank'],
                'salary' => $seedRank['salary'],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_rank_key(): void
    {
        $seedRank = SeedRank::factory()->create()->toArray();

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->show(new Request(), $seedRank['rank']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedRank['id'],
                'rank' => $seedRank['rank'],
                'salary' => $seedRank['salary'],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $controller->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_search_for_seed_ranks_via_the_rank_column(): void
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500])->toArray();
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        $three = SeedRank::factory()->create(['rank' => '10', 'salary' => 8000])->toArray();

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request(['search' => 1]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one['id'],
                    'rank' => $one['rank'],
                    'salary' => $one['salary'],
                ],
                [
                    'id' => $three['id'],
                    'rank' => $three['rank'],
                    'salary' => $three['salary'],
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_search_for_seed_ranks_via_the_salary_column(): void
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500])->toArray();
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request(['search' => 500]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one['id'],
                    'rank' => $one['rank'],
                    'salary' => $one['salary'],
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_seed_ranks_via_the_rank_column(): void
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500])->toArray();
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request(['rank' => 1]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one['id'],
                    'rank' => $one['rank'],
                    'salary' => $one['salary'],
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_seed_ranks_via_the_rank_column_using_the_like_statement(): void
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500])->toArray();
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        $three = SeedRank::factory()->create(['rank' => '10', 'salary' => 8000])->toArray();

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request(['rank' => 'like:1']));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one['id'],
                    'rank' => $one['rank'],
                    'salary' => $one['salary'],
                ],
                [
                    'id' => $three['id'],
                    'rank' => $three['rank'],
                    'salary' => $three['salary'],
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_seed_ranks_via_the_salary_column(): void
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500])->toArray();
        SeedRank::factory()->create(['rank' => '3', 'salary' => 1500]);
        SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request(['salary' => 500]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one['id'],
                    'rank' => $one['rank'],
                    'salary' => $one['salary'],
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_seed_ranks_via_the_salary_column_using_the_like_statement(): void
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500])->toArray();
        $two = SeedRank::factory()->create(['rank' => '3', 'salary' => 1500])->toArray();
        SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);
        $four = SeedRank::factory()->create(['rank' => '20', 'salary' => 15000])->toArray();

        $service = $this->app->make(SeedRankService::class);
        $transformer = new SeedRankTransformer();
        $controller = new SeedRankController($service, $transformer);

        $response = $controller->index(new Request(['salary' => 'like:500']));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one['id'],
                    'rank' => $one['rank'],
                    'salary' => $one['salary'],
                ],
                [
                    'id' => $two['id'],
                    'rank' => $two['rank'],
                    'salary' => $two['salary'],
                ],
                [
                    'id' => $four['id'],
                    'rank' => $four['rank'],
                    'salary' => $four['salary'],
                ],
            ],
        ], $response->getData(true));
    }
}

<?php

namespace Tests\Unit\Services;

use App\Models\SeedRank;
use App\Services\SeedRankService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class SeedRankServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_ranks()
    {
        $seedRanks = SeedRank::factory()->count(10)->create();

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->all(new Request());

        $sortedSeedRanks = $seedRanks->sortBy([
            [$model->getOrderByField(), $model->getOrderByDirection()],
        ]);

        $this->assertEquals($sortedSeedRanks->toArray(), $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_id_key()
    {
        $seedRank = SeedRank::factory()->create();

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->findOrFail($seedRank->id, new Request());

        $this->assertEquals($seedRank->toArray(), $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_rank_key()
    {
        $seedRank = SeedRank::factory()->create();

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->findOrFail($seedRank->rank, new Request());

        $this->assertEquals($seedRank->toArray(), $records);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $service->findOrFail('not-found', new Request());
    }

    /** @test */
    public function it_can_search_for_seed_ranks_via_the_rank_column()
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500]);
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        $three = SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->all(new Request(['search' => 1]));

        $this->assertEquals([
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
        ], $records);
    }

    /** @test */
    public function it_can_search_for_seed_ranks_via_the_salary_column()
    {
        $one = SeedRank::factory()->create(['rank' => '1', 'salary' => 500]);
        SeedRank::factory()->create(['rank' => '5', 'salary' => 3000]);
        SeedRank::factory()->create(['rank' => '10', 'salary' => 8000]);

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->all(new Request(['search' => 500]));

        $this->assertEquals([
            [
                'id' => $one->id,
                'rank' => $one->rank,
                'salary' => $one->salary,
            ],
        ], $records);
    }
}

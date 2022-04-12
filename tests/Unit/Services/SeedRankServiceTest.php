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
    public function it_will_return_a_list_of_seed_ranks(): void
    {
        $seedRanks = SeedRank::factory()->count(10)->create();

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->all(new Request());

        $this->assertCount(10, $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_id_key(): void
    {
        $seedRank = SeedRank::factory()->create()->toArray();

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->findOrFail($seedRank['id'], new Request());

        $this->assertEquals($seedRank, $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_rank_using_the_rank_key(): void
    {
        $seedRank = SeedRank::factory()->create()->toArray();

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $records = $service->findOrFail($seedRank['rank'], new Request());

        $this->assertEquals($seedRank, $records);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $model = new SeedRank();
        $service = new SeedRankService($model);

        $service->findOrFail('not-found', new Request());
    }
}

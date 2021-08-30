<?php

namespace Tests\Unit\Services;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use App\Services\SeedTestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class SeedTestServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_tests()
    {
        $seedTests = SeedTest::factory()->count(10)->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request());

        $sortedSeedTests = $seedTests->sortBy([
            [$model->getOrderByField(), $model->getOrderByDirection()],
        ]);

        $this->assertCount(10, $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_id_key()
    {
        $seedTest = SeedTest::factory()->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->findOrFail($seedTest->id, new Request());

        $this->assertEquals([
            'id' => $seedTest->id,
            'level' => $seedTest->level,
        ], $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_level_key()
    {
        $seedTest = SeedTest::factory()->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->findOrFail($seedTest->level, new Request());

        $this->assertEquals([
            'id' => $seedTest->id,
            'level' => $seedTest->level,
        ], $records);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $service->findOrFail('not-found', new Request());
    }

    /** @test */
    public function it_can_search_for_seed_tests_via_the_level_column()
    {
        $one = SeedTest::factory()->create(['level' => 1]);
        SeedTest::factory()->create(['level' => 5]);
        $three = SeedTest::factory()->create(['level' => 10]);

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request(['search' => 1]));

        $this->assertEquals([
            [
                'id' => $one->id,
                'level' => $one->level,
            ],
            [
                'id' => $three->id,
                'level' => $three->level,
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_seed_tests_via_the_level_column()
    {
        $one = SeedTest::factory()->create(['level' => 1]);
        SeedTest::factory()->create(['level' => 5]);
        SeedTest::factory()->create(['level' => 10]);

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request(['level' => 1]));

        $this->assertEquals([
            [
                'id' => $one->id,
                'level' => $one->level,
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_seed_tests_via_the_level_column_using_the_like_statement()
    {
        $one = SeedTest::factory()->create(['level' => 1]);
        SeedTest::factory()->create(['level' => 5]);
        $three = SeedTest::factory()->create(['level' => 10]);

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request(['level' => 'like:1']));

        $this->assertEquals([
            [
                'id' => $one->id,
                'level' => $one->level,
            ],
            [
                'id' => $three->id,
                'level' => $three->level,
            ],
        ], $records);
    }

    /** @test */
    public function it_can_load_the_test_questions_relation_on_a_list_of_seed_tests()
    {
        $seedTests = SeedTest::factory()
            ->count(10)
            ->has(TestQuestion::factory()->count(10))
            ->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request(['include' => 'test-questions']));

        $sortedSeedTests = $seedTests->sortBy([
            [$model->getOrderByField(), $model->getOrderByDirection()],
        ]);

        $this->assertArraySubset([
            [
                'test_questions' => [],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_load_the_test_questions_relation_on_an_individual_seed_test()
    {
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(1))
            ->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->findOrFail($seedTest->id, new Request(['include' => 'test-questions']));

        $this->assertEquals([
            'id' => $seedTest->id,
            'level' => $seedTest->level,
            'test_questions' => $seedTest->testQuestions->toArray(),
        ], $records);
    }
}

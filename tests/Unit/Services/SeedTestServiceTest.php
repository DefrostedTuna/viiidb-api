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
    public function it_will_return_a_list_of_seed_tests(): void
    {
        $seedTests = SeedTest::factory()->count(10)->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request());

        $this->assertCount(10, $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_id_key(): void
    {
        $seedTest = SeedTest::factory()->create()->toArray();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->findOrFail($seedTest['id'], new Request());

        $this->assertEquals([
            'id' => $seedTest['id'],
            'level' => $seedTest['level'],
        ], $records);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_level_key(): void
    {
        $seedTest = SeedTest::factory()->create()->toArray();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->findOrFail($seedTest['level'], new Request());

        $this->assertEquals([
            'id' => $seedTest['id'],
            'level' => $seedTest['level'],
        ], $records);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $service->findOrFail('not-found', new Request());
    }

    /** @test */
    public function it_can_load_the_test_questions_relation_on_a_list_of_seed_tests(): void
    {
        SeedTest::factory()
            ->count(10)
            ->has(TestQuestion::factory()->count(10))
            ->create();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->all(new Request(['include' => 'test-questions']));

        $this->assertArraySubset([
            [
                'test_questions' => [],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_load_the_test_questions_relation_on_an_individual_seed_test(): void
    {
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(1))
            ->create()
            ->load('testQuestions')
            ->toArray();

        $model = new SeedTest();
        $service = new SeedTestService($model);

        $records = $service->findOrFail($seedTest['id'], new Request(['include' => 'test-questions']));

        $this->assertEquals([
            'id' => $seedTest['id'],
            'level' => $seedTest['level'],
            'test_questions' => $seedTest['test_questions'],
        ], $records);
    }
}

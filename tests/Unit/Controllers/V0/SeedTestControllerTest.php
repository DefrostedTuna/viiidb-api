<?php

namespace Tests\Unit\Controllers\V0;

use App\Contracts\Services\SeedTestService;
use App\Http\Controllers\V0\SeedTestController;
use App\Http\Transformers\V0\SeedTestTransformer;
use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class SeedTestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_seed_tests(): void
    {
        SeedTest::factory()->count(10)->create();

        $service = $this->app->make(SeedTestService::class);
        $transformer = new SeedTestTransformer();
        $controller = new SeedTestController($service, $transformer);

        $response = $controller->index(new Request());

        $this->assertArraySubset([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ], $response->getData(true));
        $this->assertCount(10, $response->getData(true)['data']);
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_id_key(): void
    {
        $seedTest = SeedTest::factory()->create()->toArray();

        $service = $this->app->make(SeedTestService::class);
        $transformer = new SeedTestTransformer();
        $controller = new SeedTestController($service, $transformer);

        $response = $controller->show(new Request(), $seedTest['id']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest['id'],
                'level' => $seedTest['level'],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_will_return_an_individual_seed_test_using_the_level_key(): void
    {
        $seedTest = SeedTest::factory()->create()->toArray();

        $service = $this->app->make(SeedTestService::class);
        $transformer = new SeedTestTransformer();
        $controller = new SeedTestController($service, $transformer);

        $response = $controller->show(new Request(), $seedTest['level']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest['id'],
                'level' => $seedTest['level'],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $service = $this->app->make(SeedTestService::class);
        $transformer = new SeedTestTransformer();
        $controller = new SeedTestController($service, $transformer);

        $controller->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_load_the_test_questions_relation_on_a_list_of_seed_tests(): void
    {
        SeedTest::factory()
            ->count(10)
            ->has(TestQuestion::factory()->count(10))
            ->create();

        $service = $this->app->make(SeedTestService::class);
        $transformer = new SeedTestTransformer();
        $controller = new SeedTestController($service, $transformer);

        $response = $controller->index(new Request(['include' => 'test-questions']));

        $this->assertArraySubset([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'test_questions' => [
                        // An array of Test Questions on each record...
                    ],
                ],
            ],
        ], $response->getData(true));
        $this->assertCount(10, $response->getData(true)['data']);
    }

    /** @test */
    public function it_can_load_the_test_questions_relation_on_an_individual_seed_test(): void
    {
        $seedTest = SeedTest::factory()
            ->has(TestQuestion::factory()->count(1))
            ->create()
            ->load('testQuestions')
            ->toArray();

        $service = $this->app->make(SeedTestService::class);
        $testQuestionTransformer = $this->app->make(TestQuestionTransformer::class);
        $seedTestTransformer = $this->app->make(SeedTestTransformer::class);
        $controller = new SeedTestController($service, $seedTestTransformer);

        $response = $controller->show(new Request(['include' => 'test-questions']), $seedTest['id']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $seedTest['id'],
                'level' => $seedTest['level'],
                'test_questions' => $testQuestionTransformer->transformCollection($seedTest['test_questions']),
            ],
        ], $response->getData(true));
    }
}

<?php

namespace Tests\Unit\Controllers\V0;

use App\Contracts\Services\TestQuestionService;
use App\Http\Controllers\V0\TestQuestionController;
use App\Http\Transformers\V0\SeedTestTransformer;
use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class TestQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions(): void
    {
        TestQuestion::factory()->count(10)->create();

        $service = $this->app->make(TestQuestionService::class);
        $transformer = $this->app->make(TestQuestionTransformer::class);
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request());

        $this->assertArraySubset([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
        ], $response->getData(true));
        $this->assertCount(10, $response->getData(true)['data']);
    }

    /** @test */
    public function it_will_return_an_individual_test_question_using_the_id_key(): void
    {
        $testQuestion = TestQuestion::factory()->create()->toArray();

        $service = $this->app->make(TestQuestionService::class);
        $transformer = $this->app->make(TestQuestionTransformer::class);
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->show(new Request(), $testQuestion['id']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $testQuestion['id'],
                'sort_id' => $testQuestion['sort_id'],
                'seed_test_id' => $testQuestion['seed_test_id'],
                'question_number' => $testQuestion['question_number'],
                'question' => $testQuestion['question'],
                'answer' => $testQuestion['answer'],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = $this->app->make(TestQuestionTransformer::class);
        $controller = new TestQuestionController($service, $transformer);

        $controller->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_load_the_seed_test_relation_on_a_list_of_test_questions(): void
    {
        TestQuestion::factory()
            ->count(10)
            ->for(SeedTest::factory())
            ->create();

        $service = $this->app->make(TestQuestionService::class);
        $transformer = $this->app->make(TestQuestionTransformer::class);
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['include' => 'seed-test']));

        $this->assertArraySubset([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'seed_test' => [
                        // An array of SeeD Test data on each record...
                    ],
                ],
            ],
        ], $response->getData(true));
        $this->assertCount(10, $response->getData(true)['data']);
    }

    /** @test */
    public function it_can_load_the_seed_test_relation_on_an_individual_test_question(): void
    {
        $testQuestion = TestQuestion::factory()
            ->for(SeedTest::factory())
            ->create()
            ->load('seedTest')
            ->toArray();

        $service = $this->app->make(TestQuestionService::class);
        $seedTestTransformer = $this->app->make(SeedTestTransformer::class);
        $testQuestionTransformer = $this->app->make(TestQuestionTransformer::class);
        $controller = new TestQuestionController($service, $testQuestionTransformer);

        $response = $controller->show(new Request(['include' => 'seed-test']), $testQuestion['id']);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $testQuestion['id'],
                'sort_id' => $testQuestion['sort_id'],
                'seed_test_id' => $testQuestion['seed_test_id'],
                'question_number' => $testQuestion['question_number'],
                'question' => $testQuestion['question'],
                'answer' => $testQuestion['answer'],
                'seed_test' => $seedTestTransformer->transformRecord($testQuestion['seed_test']),
            ],
        ], $response->getData(true));
    }
}

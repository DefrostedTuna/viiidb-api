<?php

namespace Tests\Unit\Controllers\V0;

use App\Contracts\Services\TestQuestionService;
use App\Http\Controllers\V0\TestQuestionController;
use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Models\TestQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class TestQuestionControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions()
    {
        $testQuestions = TestQuestion::factory()->count(10)->create();

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
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
    public function it_will_return_an_individual_test_question_using_the_id_key()
    {
        $testQuestion = TestQuestion::factory()->create();

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->show(new Request(), $testQuestion->id);

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                'id' => $testQuestion->id,
                'sort_id' => $testQuestion->sort_id,
                'seed_test_id' => $testQuestion->seed_test_id,
                'question_number' => $testQuestion->question_number,
                'question' => $testQuestion->question,
                'answer' => $testQuestion->answer,
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found()
    {
        $this->expectException(NotFoundHttpException::class);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $controller->show(new Request(), 'not-found');
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_question_number_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['search' => 1]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_question_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['search' => 'can']));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_answer_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['search' => false]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_number_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['question_number' => 1]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_number_column_using_the_like_statement()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['question_number' => 'like:1']));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_column()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['question' => "Potions can restore a GF's HP."]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_column_using_the_like_statement()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['question' => 'like:can']));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_answer_column()
    {
        TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        $two = TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['answer' => true]));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $two->id,
                    'sort_id' => $two->sort_id,
                    'seed_test_id' => $two->seed_test_id,
                    'question_number' => $two->question_number,
                    'question' => $two->question,
                    'answer' => $two->answer,
                ],
            ],
        ], $response->getData(true));
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_answer_column_using_the_like_statement()
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ]);
        TestQuestion::factory()->create([
            'sort_id' => 2,
            'question_number' => 5,
            'question' => 'Whoever strikes the finishing blow in battle receives the most EXP.',
            'answer' => true,
        ]);
        $three = TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $service = $this->app->make(TestQuestionService::class);
        $transformer = new TestQuestionTransformer();
        $controller = new TestQuestionController($service, $transformer);

        $response = $controller->index(new Request(['answer' => 'like:f']));

        $this->assertEquals([
            'success' => true,
            'message' => 'Successfully retrieved data.',
            'status_code' => 200,
            'data' => [
                [
                    'id' => $one->id,
                    'sort_id' => $one->sort_id,
                    'seed_test_id' => $one->seed_test_id,
                    'question_number' => $one->question_number,
                    'question' => $one->question,
                    'answer' => $one->answer,
                ],
                [
                    'id' => $three->id,
                    'sort_id' => $three->sort_id,
                    'seed_test_id' => $three->seed_test_id,
                    'question_number' => $three->question_number,
                    'question' => $three->question,
                    'answer' => $three->answer,
                ],
            ],
        ], $response->getData(true));
    }
}

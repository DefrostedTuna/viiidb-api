<?php

namespace Tests\Unit\Services;

use App\Models\SeedTest;
use App\Models\TestQuestion;
use App\Services\TestQuestionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class TestQuestionServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_return_a_list_of_test_questions(): void
    {
        TestQuestion::factory()->count(10)->create();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request());

        $this->assertCount(10, $records);
    }

    /** @test */
    public function it_will_return_an_individual_test_question_using_the_id_key(): void
    {
        $testQuestion = TestQuestion::factory()->create()->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->findOrFail($testQuestion['id'], new Request());

        $this->assertEquals([
            'id' => $testQuestion['id'],
            'sort_id' => $testQuestion['sort_id'],
            'seed_test_id' => $testQuestion['seed_test_id'],
            'question_number' => $testQuestion['question_number'],
            'question' => $testQuestion['question'],
            'answer' => $testQuestion['answer'],
        ], $records);
    }

    /** @test */
    public function it_will_throw_an_exception_when_an_individual_record_is_not_found(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $service->findOrFail('not-found', new Request());
    }

    /** @test */
    public function it_can_load_the_seed_test_relation_on_a_list_of_test_questions(): void
    {
        TestQuestion::factory()
            ->count(10)
            ->for(SeedTest::factory())
            ->create();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['include' => 'seed-test']));

        $this->assertArraySubset([
            [
                'seed_test' => [],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_load_the_seed_test_relation_on_an_individual_test_question(): void
    {
        $testQuestion = TestQuestion::factory()
            ->for(SeedTest::factory())
            ->create()
            ->load('seedTest')
            ->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->findOrFail($testQuestion['id'], new Request(['include' => 'seed-test']));

        $this->assertEquals([
            'id' => $testQuestion['id'],
            'sort_id' => $testQuestion['sort_id'],
            'seed_test_id' => $testQuestion['seed_test_id'],
            'question_number' => $testQuestion['question_number'],
            'question' => $testQuestion['question'],
            'answer' => $testQuestion['answer'],
            'seed_test' => $testQuestion['seed_test'],
        ], $records);
    }
}

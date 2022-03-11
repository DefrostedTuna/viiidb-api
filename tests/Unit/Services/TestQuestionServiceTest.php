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
    public function it_can_search_for_test_questions_via_the_question_number_column(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['search' => 1]));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
            [
                'id' => $three['id'],
                'sort_id' => $three['sort_id'],
                'seed_test_id' => $three['seed_test_id'],
                'question_number' => $three['question_number'],
                'question' => $three['question'],
                'answer' => $three['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_question_column(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['search' => 'can']));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
            [
                'id' => $three['id'],
                'sort_id' => $three['sort_id'],
                'seed_test_id' => $three['seed_test_id'],
                'question_number' => $three['question_number'],
                'question' => $three['question'],
                'answer' => $three['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_search_for_test_questions_via_the_answer_column(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['search' => false]));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
            [
                'id' => $three['id'],
                'sort_id' => $three['sort_id'],
                'seed_test_id' => $three['seed_test_id'],
                'question_number' => $three['question_number'],
                'question' => $three['question'],
                'answer' => $three['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_number_column(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['question_number' => 1]));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_number_column_using_the_like_statement(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['question_number' => 'like:1']));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
            [
                'id' => $three['id'],
                'sort_id' => $three['sort_id'],
                'seed_test_id' => $three['seed_test_id'],
                'question_number' => $three['question_number'],
                'question' => $three['question'],
                'answer' => $three['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_column(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['question' => "Potions can restore a GF's HP."]));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_question_column_using_the_like_statement(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['question' => 'like:can']));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
            [
                'id' => $three['id'],
                'sort_id' => $three['sort_id'],
                'seed_test_id' => $three['seed_test_id'],
                'question_number' => $three['question_number'],
                'question' => $three['question'],
                'answer' => $three['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_answer_column(): void
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
        ])->toArray();
        TestQuestion::factory()->create([
            'sort_id' => 3,
            'question_number' => 10,
            'question' => 'You can stock up to 255 of each magic.',
            'answer' => false,
        ]);

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['answer' => true]));

        $this->assertEquals([
            [
                'id' => $two['id'],
                'sort_id' => $two['sort_id'],
                'seed_test_id' => $two['seed_test_id'],
                'question_number' => $two['question_number'],
                'question' => $two['question'],
                'answer' => $two['answer'],
            ],
        ], $records);
    }

    /** @test */
    public function it_can_filter_test_questions_via_the_answer_column_using_the_like_statement(): void
    {
        $one = TestQuestion::factory()->create([
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
        ])->toArray();
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
        ])->toArray();

        $model = new TestQuestion();
        $service = new TestQuestionService($model);

        $records = $service->all(new Request(['answer' => 'like:f']));

        $this->assertEquals([
            [
                'id' => $one['id'],
                'sort_id' => $one['sort_id'],
                'seed_test_id' => $one['seed_test_id'],
                'question_number' => $one['question_number'],
                'question' => $one['question'],
                'answer' => $one['answer'],
            ],
            [
                'id' => $three['id'],
                'sort_id' => $three['sort_id'],
                'seed_test_id' => $three['seed_test_id'],
                'question_number' => $three['question_number'],
                'question' => $three['question'],
                'answer' => $three['answer'],
            ],
        ], $records);
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

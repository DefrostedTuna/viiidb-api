<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class TestQuestionTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record()
    {
        $testQuestion = TestQuestion::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
            'arbitrary' => 'data',
        ]);

        $transformer = new TestQuestionTransformer();

        $transformedRecord = $transformer->transformRecord($testQuestion->toArray());

        $this->assertEquals([
            'id' => $testQuestion->id,
            'sort_id' => $testQuestion->sort_id,
            'seed_test_id' => $testQuestion->seed_test_id,
            'question_number' => $testQuestion->question_number,
            'question' => $testQuestion->question,
            'answer' => $testQuestion->answer,
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records()
    {
        $testQuestions = TestQuestion::factory()->count(3)->make(new Sequence(
            ['id' => 'one', 'sort_id' => 1],
            ['id' => 'two', 'sort_id' => 2],
            ['id' => 'three', 'sort_id' => 3]
        ));

        $transformer = new TestQuestionTransformer();

        $transformedRecords = $transformer->transformCollection($testQuestions->toArray());

        $this->assertEquals([
            [
                'id' => $testQuestions[0]->id,
                'sort_id' => $testQuestions[0]->sort_id,
                'seed_test_id' => $testQuestions[0]->seed_test_id,
                'question_number' => $testQuestions[0]->question_number,
                'question' => $testQuestions[0]->question,
                'answer' => $testQuestions[0]->answer,
            ],
            [
                'id' => $testQuestions[1]->id,
                'sort_id' => $testQuestions[1]->sort_id,
                'seed_test_id' => $testQuestions[1]->seed_test_id,
                'question_number' => $testQuestions[1]->question_number,
                'question' => $testQuestions[1]->question,
                'answer' => $testQuestions[1]->answer,
            ],
            [
                'id' => $testQuestions[2]->id,
                'sort_id' => $testQuestions[2]->sort_id,
                'seed_test_id' => $testQuestions[2]->seed_test_id,
                'question_number' => $testQuestions[2]->question_number,
                'question' => $testQuestions[2]->question,
                'answer' => $testQuestions[2]->answer,
            ],
        ], $transformedRecords);
    }
}

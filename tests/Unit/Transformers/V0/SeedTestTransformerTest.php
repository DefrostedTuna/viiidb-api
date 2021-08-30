<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\SeedTestTransformer;
use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Models\SeedTest;
use App\Models\TestQuestion;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SeedTestTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record()
    {
        $seedTest = SeedTest::factory()->make([
            'id' => 'some-random-uuid',
            'level' => '1',
            'arbitrary' => 'data',
        ]);

        $transformer = $this->app->make(SeedTestTransformer::class);

        $transformedRecord = $transformer->transformRecord($seedTest->toArray());

        $this->assertEquals([
            'id' => $seedTest->id,
            'level' => $seedTest->level,
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records()
    {
        $seedTests = SeedTest::factory()->count(3)->make(new Sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        ));

        $transformer = $this->app->make(SeedTestTransformer::class);

        $transformedRecords = $transformer->transformCollection($seedTests->toArray());

        $this->assertEquals([
            [
                'id' => $seedTests[0]->id,
                'level' => $seedTests[0]->level,
            ],
            [
                'id' => $seedTests[1]->id,
                'level' => $seedTests[1]->level,
            ],
            [
                'id' => $seedTests[2]->id,
                'level' => $seedTests[2]->level,
            ],
        ], $transformedRecords);
    }

    /** @test */
    public function it_will_transform_the_test_questions_records_if_they_are_present()
    {
        $seedTest = SeedTest::factory()->make(['id' => 'some-uuid'])->toArray();
        $testQuestions = TestQuestion::factory()->count(1)->make([
            'id' => 'some-random-uuid',
            'sort_id' => 1,
            'question_number' => 1,
            'question' => "Potions can restore a GF's HP.",
            'answer' => false,
            'arbitrary' => 'data',
        ])->toArray();

        // Manually append the Test Questions to the record since we're not using the database.
        $seedTest['test_questions'] = $testQuestions;

        $seedTestTransformer = $this->app->make(SeedTestTransformer::class);
        $testQuestionTransformer = $this->app->make(TestQuestionTransformer::class);

        $transformedSeedTest = $seedTestTransformer->transformRecord($seedTest);
        $transformedTestQuestions = $testQuestionTransformer->transformCollection($testQuestions);

        $this->assertArraySubset([
            'test_questions' => $transformedTestQuestions,
        ], $transformedSeedTest);
    }

    /** @test */
    public function it_will_include_the_test_questions_key_in_the_event_no_records_are_returned_from_the_relation()
    {
        $seedTest = SeedTest::factory()->make(['id' => 'some-uuid'])->toArray();

        // Manually append the Test Questions to the record since we're not using the database.
        $seedTest['test_questions'] = null;

        $seedTestTransformer = $this->app->make(SeedTestTransformer::class);

        $transformedSeedTest = $seedTestTransformer->transformRecord($seedTest);

        $this->assertArraySubset([
            'test_questions' => null,
        ], $transformedSeedTest);
    }
}

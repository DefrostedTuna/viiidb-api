<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\SeedTestTransformer;
use App\Models\SeedTest;
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

        $transformer = new SeedTestTransformer();

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

        $transformer = new SeedTestTransformer();

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
}

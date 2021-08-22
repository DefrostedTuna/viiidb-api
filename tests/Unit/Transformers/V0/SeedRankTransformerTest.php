<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\SeedRankTransformer;
use App\Models\SeedRank;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SeedRankTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record()
    {
        $seedRank = SeedRank::factory()->make([
            'id' => 'some-random-uuid',
            'rank' => '5',
            'salary' => 3000,
            'arbitrary' => 'data',
        ]);

        $transformer = new SeedRankTransformer();

        $transformedRecord = $transformer->transformRecord($seedRank->toArray());

        $this->assertEquals([
            'id' => $seedRank->id,
            'rank' => $seedRank->rank,
            'salary' => $seedRank->salary,
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records()
    {
        $seedRanks = SeedRank::factory()->count(3)->make(new Sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        ));

        $transformer = new SeedRankTransformer();

        $transformedRecords = $transformer->transformCollection($seedRanks->toArray());

        $this->assertEquals([
            [
                'id' => $seedRanks[0]->id,
                'rank' => $seedRanks[0]->rank,
                'salary' => $seedRanks[0]->salary,
            ],
            [
                'id' => $seedRanks[1]->id,
                'rank' => $seedRanks[1]->rank,
                'salary' => $seedRanks[1]->salary,
            ],
            [
                'id' => $seedRanks[2]->id,
                'rank' => $seedRanks[2]->rank,
                'salary' => $seedRanks[2]->salary,
            ],
        ], $transformedRecords);
    }
}

<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\StatTransformer;
use App\Models\Stat;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class StatTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record()
    {
        $stat = Stat::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => '1',
            'name' => 'hit points',
            'abbreviation' => 'hp',
            'arbitrary' => 'data',
        ]);

        $transformer = new StatTransformer();

        $transformedRecord = $transformer->transformRecord($stat->toArray());

        $this->assertEquals([
            'id' => $stat->id,
            'sort_id' => $stat->sort_id,
            'name' => $stat->name,
            'abbreviation' => $stat->abbreviation,
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records()
    {
        $stats = Stat::factory()->count(3)->make(new Sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        ));

        $transformer = new StatTransformer();

        $transformedRecords = $transformer->transformCollection($stats->toArray());

        $this->assertEquals([
            [
                'id' => $stats[0]->id,
                'sort_id' => $stats[0]->sort_id,
                'name' => $stats[0]->name,
                'abbreviation' => $stats[0]->abbreviation,
            ],
            [
                'id' => $stats[1]->id,
                'sort_id' => $stats[1]->sort_id,
                'name' => $stats[1]->name,
                'abbreviation' => $stats[1]->abbreviation,
            ],
            [
                'id' => $stats[2]->id,
                'sort_id' => $stats[2]->sort_id,
                'name' => $stats[2]->name,
                'abbreviation' => $stats[2]->abbreviation,
            ],
        ], $transformedRecords);
    }
}

<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\StatTransformer;
use App\Models\Stat;
use Tests\TestCase;

class StatTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record(): void
    {
        $stat = Stat::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => '1',
            'name' => 'hit points',
            'abbreviation' => 'hp',
            'arbitrary' => 'data',
        ])->toArray();

        $transformer = new StatTransformer();

        $transformedRecord = $transformer->transformRecord($stat);

        $this->assertEquals([
            'id' => $stat['id'],
            'sort_id' => $stat['sort_id'],
            'name' => $stat['name'],
            'abbreviation' => $stat['abbreviation'],
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records(): void
    {
        $stats = Stat::factory()->count(3)->sequence(
            ['id' => 'one'],
            ['id' => 'two'],
            ['id' => 'three']
        )->make()->toArray();

        $transformer = new StatTransformer();

        $transformedRecords = $transformer->transformCollection($stats);

        $this->assertEquals([
            [
                'id' => $stats[0]['id'],
                'sort_id' => $stats[0]['sort_id'],
                'name' => $stats[0]['name'],
                'abbreviation' => $stats[0]['abbreviation'],
            ],
            [
                'id' => $stats[1]['id'],
                'sort_id' => $stats[1]['sort_id'],
                'name' => $stats[1]['name'],
                'abbreviation' => $stats[1]['abbreviation'],
            ],
            [
                'id' => $stats[2]['id'],
                'sort_id' => $stats[2]['sort_id'],
                'name' => $stats[2]['name'],
                'abbreviation' => $stats[2]['abbreviation'],
            ],
        ], $transformedRecords);
    }
}

<?php

namespace Tests\Unit\Transformers\V0;

use App\Http\Transformers\V0\ElementTransformer;
use App\Models\Element;
use Tests\TestCase;

class ElementTransformerTest extends TestCase
{
    /** @test */
    public function it_will_transform_a_single_record(): void
    {
        $element = Element::factory()->make([
            'id' => 'some-random-uuid',
            'sort_id' => 1,
            'name' => 'fire',
            'arbitrary' => 'data',
        ])->toArray();

        $transformer = new ElementTransformer();

        $transformedRecord = $transformer->transformRecord($element);

        $this->assertEquals([
            'id' => $element['id'],
            'sort_id' => $element['sort_id'],
            'name' => $element['name'],
        ], $transformedRecord);
    }

    /** @test */
    public function it_will_transform_a_collection_of_records(): void
    {
        $elements = Element::factory()->count(3)->sequence(
            ['id' => 'one', 'sort_id' => 1],
            ['id' => 'two', 'sort_id' => 2],
            ['id' => 'three', 'sort_id' => 3]
        )->make()->toArray();

        $transformer = new ElementTransformer();

        $transformedRecords = $transformer->transformCollection($elements);

        $this->assertEquals([
            [
                'id' => $elements[0]['id'],
                'sort_id' => $elements[0]['sort_id'],
                'name' => $elements[0]['name'],
            ],
            [
                'id' => $elements[1]['id'],
                'sort_id' => $elements[1]['sort_id'],
                'name' => $elements[1]['name'],
            ],
            [
                'id' => $elements[2]['id'],
                'sort_id' => $elements[2]['sort_id'],
                'name' => $elements[2]['name'],
            ],
        ], $transformedRecords);
    }
}

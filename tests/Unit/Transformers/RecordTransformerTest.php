<?php

namespace Tests\Unit\Transformers;

use App\Http\Transformers\RecordTransformer;
use Tests\TestCase;

class RecordTransformerTest extends TestCase
{
    /** @test */
    public function it_will_return_an_empty_array_when_transforming_a_record_if_not_overridden()
    {
        $data = [
            'id' => 'some-random-uuid',
            'arbitrary' => 'data',
        ];

        $transformer = new RecordTransformer();

        $transformedRecord = $transformer->transformRecord($data);

        $this->assertEquals([], $transformedRecord);
    }
}

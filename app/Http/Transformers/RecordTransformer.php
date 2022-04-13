<?php

namespace App\Http\Transformers;

use App\Contracts\Transformers\RecordTransformer as RecordTransformerContract;

class RecordTransformer implements RecordTransformerContract
{
    /**
     * Transforms an individual record to standardize the output.
     *
     * @param array<string, mixed> $record The record to be transformed
     *
     * @return array<string, mixed>
     */
    public function transformRecord(array $record): array
    {
        return [];
    }

    /**
     * Transforms a collection of records to standardize the output.
     *
     * @param array<int, array<string, mixed>> $collection The collection of records to be transformed
     *
     * @return array<int, array<string, mixed>>
     */
    public function transformCollection(array $collection): array
    {
        $data = [];

        foreach ($collection as $record) {
            $data[] = $this->transformRecord($record);
        }

        return $data;
    }
}

<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class SeedRankTransformer extends RecordTransformer
{
    /**
     * Transforms an individual record to standardize the output.
     *
     * @param array $record The record to be transformed
     *
     * @return array
     */
    public function transformRecord(array $record): array
    {
        return [
            'id' => $record['id'],
            'rank' => $record['rank'],
            'salary' => $record['salary'],
        ];
    }
}

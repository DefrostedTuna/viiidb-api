<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class ElementTransformer extends RecordTransformer
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
        return [
            'id' => $record['id'],
            'sort_id' => $record['sort_id'],
            'name' => $record['name'],
        ];
    }
}

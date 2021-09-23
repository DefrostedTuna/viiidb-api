<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class StatusEffectTransformer extends RecordTransformer
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
            'name' => $record['name'],
            'type' => $record['type'],
            'description' => $record['description'],
        ];
    }
}

<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class StatusEffectTransformer extends RecordTransformer
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
        $data = [
            'id' => $record['id'],
            'sort_id' => $record['sort_id'],
            'name' => $record['name'],
            'type' => $record['type'],
            'description' => $record['description'],
        ];

        if (array_key_exists('items', $record)) {
            $data['items'] = $record['items']
                ? $this->getItemTransformer()->transformCollection($record['items'])
                : null;
        }

        return $data;
    }

    /**
     * Create a new ItemTransformer instance.
     *
     * @return ItemTransformer
     */
    protected function getItemTransformer(): ItemTransformer
    {
        return new ItemTransformer();
    }
}

<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class LocationTransformer extends RecordTransformer
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
            'region_id' => $record['region_id'],
            'parent_id' => $record['parent_id'],
            'sort_id' => $record['sort_id'],
            'slug' => $record['slug'],
            'name' => $record['name'],
            'notes' => $record['notes'],
        ];

        if (array_key_exists('region', $record)) {
            $data['region'] = $record['region']
                ? $this->getLocationTransformer()->transformRecord($record['region'])
                : null;
        }

        if (array_key_exists('parent', $record)) {
            $data['parent'] = $record['parent']
                ? $this->getLocationTransformer()->transformRecord($record['parent'])
                : null;
        }

        if (array_key_exists('locations', $record)) {
            $data['locations'] = $record['locations']
                ? $this->getLocationTransformer()->transformCollection($record['locations'])
                : [];
        }

        return $data;
    }

    /**
     * Create a new LocationTransformer instance.
     *
     * @return LocationTransformer
     */
    protected function getLocationTransformer(): LocationTransformer
    {
        return new self();
    }
}

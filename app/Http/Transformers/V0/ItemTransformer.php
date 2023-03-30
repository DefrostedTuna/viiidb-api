<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class ItemTransformer extends RecordTransformer
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
            'slug' => $record['slug'],
            'position' => $record['position'],
            'name' => $record['name'],
            'type' => $record['type'],
            'description' => $record['description'],
            'menu_effect' => $record['menu_effect'],
            'value' => $record['value'],
            'price' => $record['price'],
            'sell_high' => $record['sell_high'],
            'haggle' => $record['haggle'],
            'used_in_menu' => $record['used_in_menu'],
            'used_in_battle' => $record['used_in_battle'],
            'notes' => $record['notes'],
        ];

        if (array_key_exists('status_effects', $record)) {
            $data['status_effects'] = $record['status_effects']
                ? $this->getStatusEffectTransformer()->transformCollection($record['status_effects'])
                : null;
        }

        return $data;
    }

    /**
     * Create a new StatusEffectTransformer instance.
     *
     * @return StatusEffectTransformer
     */
    protected function getStatusEffectTransformer(): StatusEffectTransformer
    {
        return new StatusEffectTransformer();
    }
}

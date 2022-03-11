<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class TestQuestionTransformer extends RecordTransformer
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
            'seed_test_id' => $record['seed_test_id'],
            'question_number' => $record['question_number'],
            'question' => $record['question'],
            'answer' => $record['answer'],
        ];

        if (array_key_exists('seed_test', $record)) {
            $data['seed_test'] = $record['seed_test']
                ? $this->getSeedTestTransformer()->transformRecord($record['seed_test'])
                : null;
        }

        return $data;
    }

    /**
     * Create a new SeedTestTransformer instance.
     *
     * @return SeedTestTransformer
     */
    protected function getSeedTestTransformer(): SeedTestTransformer
    {
        return new SeedTestTransformer();
    }
}

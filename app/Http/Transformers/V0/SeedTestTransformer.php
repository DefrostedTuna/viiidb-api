<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class SeedTestTransformer extends RecordTransformer
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
            'level' => $record['level'],
        ];

        if (array_key_exists('test_questions', $record)) {
            $data['test_questions'] = $record['test_questions']
                ? $this->getTestQuestionTransformer()->transformCollection($record['test_questions'])
                : null;
        }

        return $data;
    }

    /**
     * Create a new TestQuestionTransformer instance.
     *
     * @return TestQuestionTransformer
     */
    protected function getTestQuestionTransformer(): TestQuestionTransformer
    {
        return new TestQuestionTransformer();
    }
}

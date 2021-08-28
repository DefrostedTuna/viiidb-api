<?php

namespace App\Http\Transformers\V0;

use App\Contracts\Transformers\RecordTransformer;

class TestQuestionTransformer implements RecordTransformer
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
            'sort_id' => $record['sort_id'],
            'seed_test_id' => $record['seed_test_id'],
            'question_number' => $record['question_number'],
            'question' => $record['question'],
            'answer' => $record['answer'],
        ];
    }

    /**
     * Transforms a collection of records to standardize the output.
     *
     * @param array $collection The collection of records to be transformed
     *
     * @return array
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

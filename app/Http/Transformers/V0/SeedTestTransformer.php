<?php

namespace App\Http\Transformers\V0;

use App\Contracts\Transformers\RecordTransformer;

class SeedTestTransformer implements RecordTransformer
{
    /**
     * Instance of the TestQuestionTransformer.
     *
     * @var TestQuestionTransformer
     */
    protected $testQuestionTransformer;

    /**
     * Transforms an individual record to standardize the output.
     *
     * @param array $record The record to be transformed
     *
     * @return array
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

    /**
     * Get the instance of the TestQuestionTransformer.
     *
     * If an existing instance does not exist, a new instance will be created.
     *
     * @return TestQuestionTransformer
     */
    protected function getTestQuestionTransformer(): TestQuestionTransformer
    {
        if (! $this->testQuestionTransformer) {
            $this->testQuestionTransformer = new TestQuestionTransformer();
        }

        return $this->testQuestionTransformer;
    }
}

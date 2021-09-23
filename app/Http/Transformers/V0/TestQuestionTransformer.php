<?php

namespace App\Http\Transformers\V0;

use App\Http\Transformers\RecordTransformer;

class TestQuestionTransformer extends RecordTransformer
{
    /**
     * Instance of the SeedTestTransformer.
     *
     * @var SeedTestTransformer
     */
    protected $seedTestTransformer;

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
     * Get the instance of the SeedTestTransformer.
     *
     * If an existing instance does not exist, a new instance will be created.
     *
     * @return SeedTestTransformer
     */
    protected function getSeedTestTransformer(): SeedTestTransformer
    {
        if (! $this->seedTestTransformer) {
            $this->seedTestTransformer = new SeedTestTransformer();
        }

        return $this->seedTestTransformer;
    }
}

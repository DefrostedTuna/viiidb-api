<?php

namespace App\Http\Transformers\V0;

use App\Contracts\Transformers\RecordTransformer;

class SearchTransformer
{
    /**
     * The transformers mapped to the plural resource names.
     *
     * @var array<string, string>
     */
    protected $transformers = [
        'elements' => ElementTransformer::class,
        'seed_ranks' => SeedRankTransformer::class,
        'seed_tests' => SeedTestTransformer::class,
        'stats' => StatTransformer::class,
        'status_effects' => StatusEffectTransformer::class,
        'test_questions' => TestQuestionTransformer::class,
    ];

    /**
     * Transform the search results using the associated resource transformer.
     *
     * @param array<string, array<int, array<string, mixed>>> $results The search results to transform
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function transformSearchResults(array $results): array
    {
        $transformed = [];

        foreach ($results as $key => $records) {
            if (array_key_exists($key, $this->transformers)) {
                /** @var RecordTransformer */
                $transformer = new $this->transformers[$key]();

                $transformed[$key] = $transformer->transformCollection($records);
            }
        }

        return $transformed;
    }
}

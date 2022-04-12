<?php

namespace App\Services\Search;

use App\Contracts\Services\Search\SearchService;
use App\Models\Element;
use App\Models\SearchableModel;
use App\Models\SeedRank;
use App\Models\SeedTest;
use App\Models\StatusEffect;
use App\Models\TestQuestion;

class MeilisearchService implements SearchService
{
    /**
     * The resources that are searchable.
     *
     * @var array<string, string>
     */
    protected $searchable = [
        'elements' => Element::class,
        'seed_ranks' => SeedRank::class,
        'seed_tests' => SeedTest::class,
        'status_effects' => StatusEffect::class,
        'test_questions' => TestQuestion::class,
    ];

    /**
     * Search the system for a subset of records.
     *
     * @param string             $query   The string by which to search
     * @param array<int, string> $only    The resources that should be searched
     * @param array<int, string> $exclude The resources that should be excluded from the search
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function search(string $query, array $only = [], array $exclude = []): array
    {
        if (! empty($only)) {
            return $this->searchResources(
                $query,
                $this->pluckResources($only)
            );
        }

        if (! empty($exclude)) {
            return $this->searchResources(
                $query,
                $this->excludeResources($exclude)
            );
        }

        return $this->searchResources($query, $this->searchable);
    }

    /**
     * Search the system for a subset of records.
     *
     * @param string                $query     The string by which to search
     * @param array<string, string> $resources The resources that are searchable
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    protected function searchResources(string $query, array $resources): array
    {
        $results = [];

        foreach ($resources as $key => $model) {
            /** @var SearchableModel */
            $instance = new $model();

            $records = $instance->search($query)
                ->orderBy(
                    $instance->getOrderByField(),
                    $instance->getOrderByDirection()
                )
                ->get();

            if (count($records)) {
                $results[$key] = $records->toArray();
            }
        }

        return $results;
    }

    /**
     * Pluck only the given resources from the ones available.
     *
     * @param array<int, string> $only The resources that should be searched
     *
     * @return array<string, string>
     */
    protected function pluckResources(array $only): array
    {
        return array_intersect_key(
            $this->searchable,
            array_flip($only)
        );
    }

    /**
     * Exclude the given resources from the ones available.
     *
     * @param array<int, string> $exclude The resources that should be excluded from the search
     *
     * @return array<string, string>
     */
    protected function excludeResources(array $exclude): array
    {
        return array_diff_key(
            $this->searchable,
            array_flip($exclude)
        );
    }
}

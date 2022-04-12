<?php

namespace App\Contracts\Services\Search;

interface SearchService
{
    /**
     * Search the system for a subset of records.
     *
     * @param string   $query   The string by which to search
     * @param string[] $only    The resources that should be searched
     * @param string[] $exclude The resources that should be excluded from the search
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    public function search(string $query, array $only = [], array $exclude = []): array;
}

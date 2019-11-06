<?php

namespace App\Traits;

use App\Helpers\QueryRequestFilter;
use Illuminate\Http\Request;

trait Filterable 
{
    /**
     * The relationships that are explicitly marked as valid through requests.
     *
     * @return array
     */
    public function getValidRelations(): array
    {
        return isset($this->validRelations)
            ? $this->validRelations
            : [];
    }
    /**
     * The fields that are explicitly enabled for filtering.
     *
     * @return array
     */
    public function getFilterableFields(): array
    {
        return isset($this->filterableFields)
            ? $this->filterableFields
            : [];
    }

    /**
     * The operators that are explicitly enabled for filtering.
     *
     * @return array
     */
    public function getFilterableOperators(): array
    {
        $defaultOperators = [
            'lt' => '<',
            'lte' => '<=',
            'gt' => '>',
            'gte' => '>=',
            'like' => 'like',
            'not' => '<>',
        ];

        return isset($this->filterableOperators)
            ? $this->filterableOperators
            : $defaultOperators;
    }

    /**
     * The operators that are explicitly for filtering integer values.
     *
     * @return array
     */
    public function getNumericalOperators(): array
    {
        return [
            '<',
            '<=',
            '>',
            '>=',
        ];
    }

    /**
     * The default field which the records should be sorted by.
     *
     * @return string
     */
    public function getOrderByField(): string
    {
        return isset($this->orderByField)
            ? $this->orderByField
            : $this->getKeyName;
    }

    /**
     * The direction in which records should be sorted by default.
     *
     * @return string
     */
    public function getOrderByDirection(): string
    {
        return isset($this->orderByDirection)
            ? $this->orderByDirection
            : 'desc';
    }

    /**
     * Filters query results by the given parameters.
     *
     * @param array $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function applyRequestFilters(array $filters): \Illuminate\Database\Eloquent\Collection
    {
        $query = new QueryRequestFilter($this->getModel());

        return $query->loadRelations($filters)
            ->applyFilters($filters)
            ->getResults();
    }
}
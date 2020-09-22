<?php

namespace App\Traits;

use App\Helpers\QueryRequestFilter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
     * @param  array  $filters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilteredRecords(array $filters): Collection
    {
        $query = new QueryRequestFilter($this->getModel());

        $query->loadRelations($filters)->applyFilters($filters);

        return $query->getResults();
    }

    /**
     * Fetches a record with the applicable relations requested by the filters.
     *
     * @param  string  $id
     * @param  array   $filters
     * @param  string  $column
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getRecordWithRelations(string $id, array $filters, string $column = 'id'): Model
    {
        $query = new QueryRequestFilter($this->getModel());

        return $query->loadRelations($filters)->getResult($id, $column);
    }
}

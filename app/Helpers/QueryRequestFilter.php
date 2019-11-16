<?php

namespace App\Helpers;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class QueryRequestFilter
{
    /**
     * Instance of the filterable class.
     *
     * @var \Illuminate\Database\Eloquent\Model $filterable
     */
    protected $filterable;

    /**
     * Instance of the query builder.
     * 
     * @var Illuminate\Database\Eloquent\Builder $query
     */
    protected $query;

    /**
     * Sets the model and query builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * 
     * @return void;
     */
    public function __construct(Model $model)
    {
        $this->filterable = $model;
        $this->query = $model->newQuery();
    }

    /**
     * Filters query results by the given parameters.
     *
     * @param array $filters
     *
     * @return \App\Helpers\QueryRequestFilter
     */
    public function applyFilters(array $filters): \App\Helpers\QueryRequestFilter
    {
        $fieldNames = array_intersect(
            $this->filterable->getFilterableFields(),
            array_keys($filters)
        );

        foreach ($fieldNames as $fieldName) {
            $param = strtolower($filters[$fieldName]);
            $operator = $this->parseComparisonOperator($param);
            $fieldValue = $this->parseFieldValue($param);

            // Check if the value can be converted to an integer.
            if ((int)$fieldValue) {
                $fieldValue = (int)$fieldValue;
            }

            if ($operator === 'like') {
                $fieldValue = "%{$fieldValue}%";
            }

            // If the desired comparison operator is comparing an integer value,
            // then we want to cast the column as an integer so it checks the values properly.
            // If the comparison operator is not looking for an integer, then we want to
            // cast the desired column to lowercase and compare afterwards.
            if (in_array($operator, $this->filterable->getNumericalOperators())) {
                $this->query->whereRaw("CAST({$fieldName} AS UNSIGNED) ${operator} \"{$fieldValue}\"");
            } else {
                $this->query->whereRaw("LOWER({$fieldName}) ${operator} \"{$fieldValue}\"");
            }
        }

        return $this;
    }

    /**
     * Loads valid relations present in the filters.
     *
     * @param array $filters
     *
     * @return \App\Helpers\QueryRequestFilter
     */
    public function loadRelations(array $filters): \App\Helpers\QueryRequestFilter
    {
        if (!array_key_exists('with', $filters)) {
            return $this;
        }

        $relations = $this->parseRelations($filters['with']);

        if (count($relations) > 0) {
            $this->query->with($relations);
        }

        return $this;
    }

    /**
     * Fetch a specific record from the database, or fail trying to do so.
     *
     * @param string $id
     * 
     * @return \Illuminate\Database\Eloquent\Model
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getResult(string $id): \Illuminate\Database\Eloquent\Model
    {
        return $this->query->where('id', $id)->firstOrFail();
    }

    /**
     * Fetches query results and sorts them according to the defined column and direction.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getResults(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->query->orderBy(
            $this->filterable->getOrderByField(),
            $this->filterable->getOrderByDirection()
        )->get();
    }

    /**
     * Converts an array of relation fields into a string that the query builder expects.
     *
     * @param string $relation
     * @param array $columns
     *
     * @return string
     */
    protected function constructRelationString(string $relation, array $columns): string
    {
        $visibleFields = $this->filterable->{$relation}()->getRelated()->getVisible();
        $foreignKeyName = $this->filterable->{$relation}()->getForeignKeyName();
        $intersectingFields = array_intersect($columns, $visibleFields);

        // The ID field must always be included for the query to succeed.
        if (count($intersectingFields) > 0) {
            $fields = implode(',', $intersectingFields);
            return "{$relation}:id,{$foreignKeyName},{$fields}";
        }

        return $relation;
    }

    /**
     * Converts the relations in the query string into an array of strings that the query builder expects.
     *
     * @param string $filters
     *
     * @return array
     */
    protected function parseRelations(string $filters): array
    {
        $validRelations = $this->filterable->getValidRelations();
        $requestedRelations = [];
        $relations = [];

        foreach(explode(',', $filters) as $relationString) {
            $relationArray = explode('.', $relationString, 2);

            if (!array_key_exists($relationArray[0], $requestedRelations)) {
                $requestedRelations[$relationArray[0]] = [];
            }

            // If a specific column is desired, add it to the array.
            if (count($relationArray) > 1) {
                $requestedRelations[$relationArray[0]][] = $relationArray[1];
            }
        }

        foreach ($requestedRelations as $relation => $columns) {
            if (in_array($relation, $validRelations)) {
                $relations[] = $this->constructRelationString($relation, $columns);
            }
        }

        return $relations;
    }

    /**
     * Extracts the comparison operator from the query string.
     *
     * @param string $value
     *
     * @return string
     */
    protected function parseComparisonOperator(string $value): string
    {
        $filterableOperators = $this->filterable->getFilterableOperators();
        $splitValue = explode(':', $value);

        // If the array has more than one value, there is an operator.
        if (count($splitValue) > 1) {
            return in_array($splitValue[0], array_keys($filterableOperators))
                ? $filterableOperators[$splitValue[0]]
                : '=';
        }

        return '=';
    }

    /**
     * Extracts the desired value by which a user wishes filter.
     *
     * @param string $value
     *
     * @return string
     */
    protected function parseFieldValue(String $value): string
    {
        // Splitting by three will ignore anything after the second colon.
        $splitValue = explode(':', $value, 3);

        return count($splitValue) > 1
            ? $splitValue[1]
            : $value;
    }
}
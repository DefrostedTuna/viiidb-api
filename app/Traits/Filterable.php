<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Filterable 
{
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
    public function applyRequestFilters(array $request): \Illuminate\Database\Eloquent\Collection
    {
        $fieldNames = array_intersect(
            $this->getFilterableFields(),
            array_keys($request)
        );

        $query = $this->newQuery();

        foreach ($fieldNames as $fieldName) {
            $param = strtolower($request[$fieldName]);

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
            if (in_array($operator, $this->getNumericalOperators())) {
                $query->whereRaw("CAST({$fieldName} AS UNSIGNED) ${operator} \"{$fieldValue}\"");
            } else {
                $query->whereRaw("LOWER({$fieldName}) ${operator} \"{$fieldValue}\"");
            }
        }

        return $query->orderBy(
            $this->getOrderByField(), 
            $this->getOrderByDirection()
        )->get();
    }

    /**
     * Extracts the comparison operator from the query string.
     *
     * @param string $value
     *
     * @return string
     */
    public function parseComparisonOperator(string $value): string
    {
        $filterableOperators = $this->getFilterableOperators();
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
    public function parseFieldValue(String $value): string
    {
        // Splitting by three will ignore anything after the second colon.
        $splitValue = explode(':', $value, 3);

        return count($splitValue) > 1
            ? $splitValue[1]
            : $value;
    }
}
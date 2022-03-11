<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait FiltersRecordsByFields
{
    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var string[]
     */
    protected $filterableFields = [];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @return string[]
     */
    public function getFilterableFields(): array
    {
        return $this->filterableFields;
    }

    /**
     * Filter the records by the given criteria.
     *
     * @param Builder<Model>       $query   The Eloquent Query Builder instance
     * @param array<string, mixed> $filters An array of `key => value` pairs that correspond to `column => filter`
     *
     * @return Builder<Model>
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $casts = $this->getCasts();
        $filters = array_intersect_key(
            $filters,
            array_flip($this->getFilterableFields())
        );

        foreach ($filters as $column => $value) {
            $type = array_key_exists($column, $casts) ? $casts[$column] : 'string';
            $operator = '=';

            // Check for a "like" operator.
            $pieces = explode(':', $value);
            if (strtolower($pieces[0]) === 'like') {
                $operator = 'LIKE';

                $impl = implode(':', array_slice($pieces, 1));
                $value = "%{$impl}%";
            }

            // Sanitize boolean values so they are not converted to "1" / "".
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }

            /*
             * Search for 'true' or 'false' with boolean fields rather than '1' or '0'.
             * This will prevent issues where we are looking for an integer, but instead
             * return a field with a boolean value rather than what was originally intended.
             */
            if ($type === 'boolean') {
                $castStatement = "CASE WHEN {$column} = 1 THEN 'true' ELSE 'false' END";

                $query->whereRaw("{$castStatement} {$operator} ?", $value);
            } else {
                $query->where($column, $operator, $value);
            }
        }

        return $query;
    }
}

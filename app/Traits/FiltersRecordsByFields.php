<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FiltersRecordsByFields
{
    /**
     * The fields that can be used as a filter on the resource.
     *
     * @return array
     */
    public function getFilterableFields(): array
    {
        return isset($this->filterableFields) ? $this->filterableFields : [];
    }

    /**
     * Filter the records by the given criteria.
     *
     * @param Builder $query   The Eloquent Query Builder instance
     * @param array   $filters An array of `key => value` pairs that correspond to `field => filter`
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $filters = array_intersect_key(
            $filters,
            array_flip($this->getFilterableFields())
        );

        foreach ($filters as $key => $value) {
            $pieces = explode(':', $value);
            $hasLikeOperator = strtolower($pieces[0]) === 'like';

            if ($hasLikeOperator) {
                $impl = implode(':', array_slice($pieces, 1));
                $value = "%{$impl}%";
            }

            $query->where(
                $key,
                $hasLikeOperator ? 'LIKE' : '=',
                $value
            );
        }

        return $query;
    }
}

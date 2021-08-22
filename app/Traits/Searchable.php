<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Get the fields that should be searchable.
     *
     * @return array
     */
    public function getSearchableFields(): array
    {
        return isset($this->searchableFields) ? $this->searchableFields : [];
    }

    /**
     * Search the columns defined on the model for the specified value.
     *
     * @param Builder $query The Eloquent Query Builder instance
     * @param mixed   $value The value to search for on the columns
     *
     * @return Builder
     */
    public function scopeSearch(Builder $query, mixed $value): Builder
    {
        foreach ($this->getSearchableFields() as $key => $column) {
            $clause = 0 === $key ? 'where' : 'orWhere';

            $query->{$clause}($column, 'LIKE', "%{$value}%");
        }

        return $query;
    }
}

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
        // Sanitize boolean values so they are not converted to "1" / "".
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        foreach ($this->getSearchableFields() as $key => $column) {
            $clause = $key === 0 ? 'where' : 'orWhere';
            $casts = $this->getCasts();
            $type = array_key_exists($column, $casts) ? $casts[$column] : 'string';

            /*
             * Search for 'true' or 'false' with boolean fields rather than '1' or '0'.
             * This will prevent issues where we are looking for an integer, but instead
             * return a field with a boolean value rather than what was originally intended.
             */
            if ($type === 'boolean') {
                $clause = "{$clause}Raw";
                $castStatement = "CASE WHEN {$column} = 1 THEN 'true' ELSE 'false' END";

                $query->{$clause}("{$castStatement} LIKE ?", "%{$value}%");
            } else {
                $query->{$clause}($column, 'LIKE', "%{$value}%");
            }
        }

        return $query;
    }
}

<?php

namespace App\Models;

use Laravel\Scout\Searchable;

class SearchableModel extends Model
{
    use Searchable;

    /**
     * The fields that should be searchable.
     *
     * @var array<int, string>
     */
    protected $searchableFields = [];

    /**
     * Get the fields that should be searchable.
     *
     * @return array<int, string>
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }
}

<?php

namespace App\Models;

use Laravel\Scout\Searchable;

class SearchableModel extends Model
{
    use Searchable;

    /**
     * The fields that should be searchable.
     *
     * @var string[]
     */
    protected $searchableFields = [];

    /**
     * Get the fields that should be searchable.
     *
     * @return string[]
     */
    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }
}

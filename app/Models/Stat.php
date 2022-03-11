<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stats';

    /**
     * The default field used to order query results by.
     *
     * @var string
     */
    protected $orderByField = 'sort_id';

    /**
     * The default direction used to order query results by.
     *
     * @var string
     */
    protected $orderByDirection = 'asc';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var string[]
     */
    protected $visible = [
        'id',
        'sort_id',
        'name',
        'abbreviation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'           => 'string',
        'sort_id'      => 'integer',
        'name'         => 'string',
        'abbreviation' => 'string',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var string[]
     */
    protected $searchableFields = [];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var string[]
     */
    protected $filterableFields = [];
}

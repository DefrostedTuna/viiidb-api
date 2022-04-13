<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeedRank extends SearchableModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_ranks';

    /**
     * The default field used to order query results by.
     *
     * @var string
     */
    protected $orderByField = 'salary';

    /**
     * The default direction used to order query results by.
     *
     * @var string
     */
    protected $orderByDirection = 'asc';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'rank',
        'salary',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'     => 'string',
        'rank'   => 'string',
        'salary' => 'integer',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array<int, string>
     */
    protected $searchableFields = [
        'rank',
        'salary',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var string[]
     */
    protected $filterableFields = [
        'rank',
        'salary',
    ];

    /*
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'rank';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusEffect extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'status_effects';

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
     * @var array
     */
    protected $visible = [
        'id',
        'sort_id',
        'name',
        'type',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'string',
        'sort_id'     => 'integer',
        'name'        => 'string',
        'type'        => 'string',
        'description' => 'string',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array
     */
    protected $searchableFields = [
        'name',
        'type',
        'description',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @return array
     */
    protected $filterableFields = [
        'name',
        'type',
        'description',
    ];

    /*
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}

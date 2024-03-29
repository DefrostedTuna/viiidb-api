<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StatusEffect extends SearchableModel
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
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'sort_id',
        'name',
        'type',
        'description',
        'items',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
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
     * @var array<int, string>
     */
    protected $searchableFields = [
        'name',
        'type',
        'description',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var array<int, string>
     */
    protected $filterableFields = [
        'name',
        'type',
        'description',
    ];

    /**
     * The relations that are available to include with the resource.
     *
     * @var array<int, string>
     */
    protected $availableIncludes = [
        'items',
    ];

    /**
     * The default relations to include with the resource.
     *
     * @var array<int, string>
     */
    protected $defaultIncludes = [];

    /*
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }

    /**
     * The items that are associated with the status effect.
     * 
     * @return BelongsToMany<Item>
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}

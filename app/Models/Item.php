<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends SearchableModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The default field used to order query results by.
     *
     * @var string
     */
    protected $orderByField = 'position';

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
        'slug',
        'position',
        'name',
        'type',
        'description',
        'menu_effect',
        'value',
        'price',
        'sell_high',
        'haggle',
        'used_in_menu',
        'used_in_battle',
        'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'slug' => 'string',
        'position' => 'integer',
        'name' => 'string',
        'type' => 'string',
        'description' => 'string',
        'menu_effect' => 'string',
        'value' => 'integer',
        'price' => 'integer',
        'sell_high' => 'integer',
        'haggle' => 'integer',
        'used_in_menu' => 'boolean',
        'used_in_battle' => 'boolean',
        'notes' => 'string',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array<int, string>
     */
    protected $searchableFields = [
        'slug',
        'position',
        'name',
        'type',
        'description',
        'menu_effect',
        'value',
        'price',
        'sell_high',
        'haggle',
        'used_in_menu',
        'used_in_battle',
        'notes',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var string[]
     */
    protected $filterableFields = [
        'slug',
        'position',
        'name',
        'type',
        'description',
        'menu_effect',
        'value',
        'price',
        'sell_high',
        'haggle',
        'used_in_menu',
        'used_in_battle',
        'notes',
    ];

    /*
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

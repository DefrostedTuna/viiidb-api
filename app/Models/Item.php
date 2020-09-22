<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Uuids;
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The 'type' of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The default field used to order query results by.
     *
     * @var array
     */
    protected $orderByField = 'position';

    /**
     * The default direction used to order query results by.
     *
     * @var array
     */
    protected $orderByDirection = 'asc';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'position',
        'name',
        'type',
        'description',
        'menu_effect',
        'price',
        'value',
        'haggle',
        'sell_high',
        'used_in_menu',
        'used_in_battle',
        'notes',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array $hidden
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id'                        => 'string',
        'position'                  => 'integer',
        'name'                      => 'string',
        'type'                      => 'string',
        'description'               => 'string',
        'menu_effect'               => 'string',
        'price'                     => 'integer',
        'value'                     => 'integer',
        'haggle'                    => 'integer',
        'sell_high'                 => 'integer',
        'used_in_menu'              => 'boolean',
        'used_in_battle'            => 'boolean',
        'notes'                     => 'string',
    ];

    /**
     * The relationships that are explicitly marked as valid through requests.
     *
     * @return array $validRelations
     */
    protected $validRelations = [
        //
    ];

    /**
     * The fields that are explicitly enabled for filtering.
     *
     * @var array $filterableFields
     */
    protected $filterableFields = [
        'position',
        'name',
        'type',
        'description',
        'menu_effect',
        'price',
        'value',
        'haggle',
        'sell_high',
        'used_in_menu',
        'used_in_battle',
        'notes',
    ];

    /**
     * The operators that are explicitly enabled for filtering.
     *
     * @return array
     */
    protected $filterableOperators = [
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'like',
        'not' => '<>',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}

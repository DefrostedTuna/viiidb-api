<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SeedRank extends Model
{
    use Uuids;
    use Filterable;

    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_ranks';

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
    protected $orderByField = 'salary';

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
        'rank',
        'salary',
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
        'rank' => 'string',
        'salary' => 'integer',
    ];

    /**
     * The fields that are explicitly enabled for filtering.
     *
     * @var array $filterableFields
     */
    protected $filterableFields = [
        'rank',
        'salary',
    ];
}

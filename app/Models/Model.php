<?php

namespace App\Models;

use App\Traits\FiltersRecordsByFields;
use App\Traits\LoadsRelationsThroughServices;
use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use FiltersRecordsByFields;
    use LoadsRelationsThroughServices;
    use OrdersQueryResults;
    use Searchable;
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The 'type' of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

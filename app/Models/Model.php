<?php

namespace App\Models;

use App\Traits\LoadsRelationsThroughServices;
use App\Traits\OrdersQueryResults;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use LoadsRelationsThroughServices;
    use OrdersQueryResults;
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
     * @var string[]
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}

<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use Uuids;
    use Filterable;

    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

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
    protected $orderByField = 'name';

    /**
     * The default direction used to order query results by.
     *
     * @var array
     */
    protected $orderByDirection = 'asc';

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
        'name' => 'string',
        'description' => 'string',
        'area' => 'string',
    ];

    /**
     * The fields that are explicitly enabled for filtering.
     *
     * @var array $filterableFields
     */
    protected $filterableFields = [
        'name',
        'area',
    ];

    /**
     * The operators that are explicitly enabled for filtering.
     *
     * @return array
     */
    protected $filterableOperators = [
        'like' => 'like',
        'not' => '<>',
    ];

    /**
     * The region that the location belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class, 'region_id', 'id');
    }
}

<?php

namespace App\Models;

use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeedRank extends Model
{
    use HasFactory;
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_ranks';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

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
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'     => 'string',
        'rank'   => 'string',
        'salary' => 'integer',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array
     */
    protected $searchableFields = [
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

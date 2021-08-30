<?php

namespace App\Models;

use App\Traits\FiltersRecordsByFields;
use App\Traits\LoadsRelationsThroughServices;
use App\Traits\OrdersQueryResults;
use App\Traits\Searchable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeedTest extends Model
{
    use FiltersRecordsByFields;
    use HasFactory;
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_tests';

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
    protected $orderByField = 'level';

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
        'level',
        'testQuestions',
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
        'id'    => 'string',
        'level' => 'int',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array
     */
    protected $searchableFields = [
        'level',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @return array
     */
    protected $filterableFields = [
        'level',
    ];

    /**
     * The relations that are available to include with the resource.
     *
     * @var array
     */
    protected $availableIncludes = [
        'testQuestions',
    ];

    /**
     * The default relations to include with the resource.
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /*
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'level';
    }

    /**
     * The Test Questions that are associated with the record.
     *
     * @return HasMany
     */
    public function testQuestions(): HasMany
    {
        return $this->hasMany(TestQuestion::class, 'seed_test_id', 'id');
    }
}

<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeedTest extends Model
{
    use Uuids;
    use Filterable;

    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_tests';

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
    protected $orderByField = 'level';

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
        'level',
        'questions',
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
        'id'    => 'string',
        'level' => 'integer',
    ];

    /**
     * The relationships that are explicitly marked as valid through requests.
     *
     * @return array $validRelations
     */
    protected $validRelations = [
        'questions',
    ];

    /**
     * The fields that are explicitly enabled for filtering.
     *
     * @var array $filterableFields
     */
    protected $filterableFields = [
        'level',
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
     * The questions that relate to the test.
     *
     * @return 
     */
    public function questions()
    {
        return $this->hasMany(TestQuestion::class, 'seed_test_id', 'id');
    }
}

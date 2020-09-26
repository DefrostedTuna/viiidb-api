<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestQuestion extends Model
{
    use Uuids;
    use Filterable;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'test_questions';

    /**
     * The 'type' of the primary key ID.
     *
     * @var string $keyType
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool $incrementing
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [];

    /**
     * The default field used to order query results by.
     *
     * @var array $orderByField
     */
    protected $orderByField = 'question_number';

    /**
     * The default direction used to order query results by.
     *
     * @var array $orderByDirection
     */
    protected $orderByDirection = 'asc';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array $visible
     */
    protected $visible = [
        'id',
        'seed_test_id',
        'question_number',
        'question',
        'answer',
        'test',
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
        'id'                => 'string',
        'seed_test_id'      => 'string',
        'question_number'   => 'integer',
        'question'          => 'string',
        'answer'            => 'string',
    ];

    /**
     * The relationships that are explicitly marked as valid through requests.
     *
     * @return array $validRelations
     */
    protected $validRelations = [
        'test',
    ];

    /**
     * The fields that are explicitly enabled for filtering.
     *
     * @var array $filterableFields
     */
    protected $filterableFields = [
        'question_number',
        'question',
        'answer',
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
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * The SeedTest that the record belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(SeedTest::class, 'seed_test_id', 'id');
    }
}

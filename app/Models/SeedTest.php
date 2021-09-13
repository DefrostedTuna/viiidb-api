<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeedTest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_tests';

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
        'testQuestions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'    => 'string',
        'level' => 'integer',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeedTest extends SearchableModel
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
     * @var string
     */
    protected $orderByField = 'level';

    /**
     * The default direction used to order query results by.
     *
     * @var string
     */
    protected $orderByDirection = 'asc';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var string[]
     */
    protected $visible = [
        'id',
        'level',
        'testQuestions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id'    => 'string',
        'level' => 'integer',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var string[]
     */
    protected $searchableFields = [
        'level',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var string[]
     */
    protected $filterableFields = [
        'level',
    ];

    /**
     * The relations that are available to include with the resource.
     *
     * @var string[]
     */
    protected $availableIncludes = [
        'testQuestions',
    ];

    /**
     * The default relations to include with the resource.
     *
     * @var string[]
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
     * @return HasMany<TestQuestion>
     */
    public function testQuestions(): HasMany
    {
        return $this->hasMany(TestQuestion::class, 'seed_test_id', 'id');
    }
}

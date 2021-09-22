<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestQuestion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_questions';

    /**
     * The default field used to order query results by.
     *
     * @var string
     */
    protected $orderByField = 'sort_id';

    /**
     * The default direction used to order query results by.
     *
     * @var string
     */
    protected $orderByDirection = 'asc';

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'sort_id',
        'seed_test_id',
        'question_number',
        'question',
        'answer',
        'seedTest',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'string',
        'sort_id'         => 'integer',
        'seed_test_id'    => 'string',
        'question_number' => 'integer',
        'question'        => 'string',
        'answer'          => 'boolean',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array
     */
    protected $searchableFields = [
        'question_number',
        'question',
        'answer',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @return array
     */
    protected $filterableFields = [
        'question_number',
        'question',
        'answer',
    ];

    /**
     * The relations that are available to include with the resource.
     *
     * @var array
     */
    protected $availableIncludes = [
        'seedTest',
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
        return 'id';
    }

    /**
     * The SeeD Test that the record belongs to.
     *
     * @return BelongsTo
     */
    public function seedTest(): BelongsTo
    {
        return $this->belongsTo(SeedTest::class, 'seed_test_id', 'id');
    }
}

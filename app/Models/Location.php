<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends SearchableModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

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
     * @var array<int, string>
     */
    protected $visible = [
        'id',
        'region_id',
        'parent_id',
        'sort_id',
        'slug',
        'name',
        'notes',
        'region',
        'parent',
        'locations',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'region_id' => 'string',
        'parent_id' => 'string',
        'sort_id' => 'integer',
        'slug' => 'string',
        'name' => 'string',
        'notes' => 'string',
    ];

    /**
     * The fields that should be searchable.
     *
     * @var array<int, string>
     */
    protected $searchableFields = [
        'slug',
        'name',
        'notes',
    ];

    /**
     * The fields that can be used as a filter on the resource.
     *
     * @var string[]
     */
    protected $filterableFields = [
        'slug',
        'name',
        'notes',
    ];

    /**
     * The relations that are available to include with the resource.
     *
     * @var array<int, string>
     */
    protected $availableIncludes = [
        'region',
        'parent',
        'locations',
    ];

    /**
     * The default relations to include with the resource.
     *
     * @var array<int, string>
     */
    protected $defaultIncludes = [];

    /*
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The region that the record belongs to.
     *
     * @return BelongsTo<Location, Location>
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'region_id', 'id');
    }

    /**
     * The parent location that the record belongs to.
     *
     * @return BelongsTo<Location, Location>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id', 'id');
    }

    /**
     * The child locations that are associated with the record.
     *
     * @return HasMany<Location>
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id', 'id');
    }
}

<?php

namespace App\Traits;

use App\Scopes\OrderQueryResults;

trait OrdersQueryResults
{
    /**
     * The default field used to order query results by.
     *
     * @var string
     */
    protected $orderByField = '';

    /**
     * The default direction used to order query results by.
     *
     * @var string
     */
    protected $orderByDirection = 'asc';

    /**
     * The default field which the records should be sorted by.
     *
     * @return string
     */
    public function getOrderByField(): string
    {
        return $this->orderByField ?: $this->getKeyName();
    }

    /**
     * The direction in which records should be sorted by default.
     *
     * @return string
     */
    public function getOrderByDirection(): string
    {
        return $this->orderByDirection;
    }

    /**
     * Bootstrap the trait on the model.
     */
    protected static function bootOrdersQueryResults(): void
    {
        static::addGlobalScope(new OrderQueryResults());
    }
}

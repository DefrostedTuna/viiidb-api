<?php

namespace App\Traits;

use App\Scopes\OrderQueryResults;

trait OrdersQueryResults
{
    /**
     * The default field which the records should be sorted by.
     *
     * @return string
     */
    public function getOrderByField(): string
    {
        return isset($this->orderByField) ? $this->orderByField : $this->getKeyName;
    }

    /**
     * The direction in which records should be sorted by default.
     *
     * @return string
     */
    public function getOrderByDirection(): string
    {
        return isset($this->orderByDirection) ? $this->orderByDirection : 'asc';
    }

    /**
     * Bootstrap the trait on the model.
     */
    protected static function bootOrdersQueryResults()
    {
        static::addGlobalScope(new OrderQueryResults());
    }
}

<?php

namespace App\Traits;

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
        return isset($this->orderByDirection) ? $this->orderByDirection : 'desc';
    }
}

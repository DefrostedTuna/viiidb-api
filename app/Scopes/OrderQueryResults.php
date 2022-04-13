<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderQueryResults implements Scope
{
    /**
     * Order the query results by what is configured on the model.
     *
     * @param Builder<Model> $builder The instance of the Eloquent query builder
     * @param Model          $model   The instance of the current model
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (
            method_exists($model, 'getOrderByField') &&
            method_exists($model, 'getOrderByDirection')
        ) {
            $builder->orderBy(
                $model->getOrderByField(),
                $model->getOrderByDirection()
            );
        }
    }
}

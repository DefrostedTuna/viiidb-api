<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate(4)->string;
        });

        // Prevent attempts to change a record's ID.
        static::saving(function ($model) {
            $originalUuid = $model->getOriginal($model->getKeyName());

            if ($originalUuid !== $model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = $originalUuid;
            }
        });
    }
}
<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * Bootstrap the trait on the model.
     */
    protected static function bootUuids(): void
    {
        static::creating(function (\App\Models\Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate(4)->string;
        });

        // Prevent attempts to change a record's ID.
        static::saving(function (\App\Models\Model $model) {
            $originalUuid = $model->getOriginal($model->getKeyName());

            if ($originalUuid !== $model->{$model->getKeyName()}) {
                $model->{$model->getKeyName()} = $originalUuid;
            }
        });
    }
}

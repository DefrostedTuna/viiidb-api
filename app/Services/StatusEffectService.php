<?php

namespace App\Services;

use App\Contracts\Services\StatusEffectService as StatusEffectServiceContract;
use App\Models\StatusEffect;

class StatusEffectService extends ModelService implements StatusEffectServiceContract
{
    /**
     * Create a new StatusEffectService instance.
     *
     * @param StatusEffect $model The instance of the model to use for the service
     */
    public function __construct(StatusEffect $model)
    {
        $this->model = $model;
    }
}

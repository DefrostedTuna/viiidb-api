<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\StatusEffectService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\StatusEffectTransformer;

class StatusEffectController extends ResourceController
{
    /**
     * Create a new StatusEffectController instance.
     *
     * @param StatusEffectService     $statusEffectService     The Service that will process the request
     * @param StatusEffectTransformer $statusEffectTransformer The Transformer that will standardize the response
     */
    public function __construct(StatusEffectService $statusEffectService, StatusEffectTransformer $statusEffectTransformer)
    {
        $this->service = $statusEffectService;
        $this->transformer = $statusEffectTransformer;
    }
}

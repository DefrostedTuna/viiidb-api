<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\StatusEffectService;
use App\Http\Controllers\RelationalResourceController;
use App\Http\Transformers\V0\ItemTransformer;

class StatusEffectItemController extends RelationalResourceController
{
    /**
     * Create a new StatusEffectItemController instance.
     *
     * @param StatusEffectService $statusEffectService The Service that will process the request
     * @param ItemTransformer     $itemTransformer     The Transformer that will standardize the response
     */
    public function __construct(StatusEffectService $statusEffectService, ItemTransformer $itemTransformer)
    {
        $this->service = $statusEffectService;
        $this->transformer = $itemTransformer;
        $this->relation = 'items';
    }
}

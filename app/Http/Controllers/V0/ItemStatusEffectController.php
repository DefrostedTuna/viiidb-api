<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\ItemService;
use App\Http\Controllers\RelationalResourceController;
use App\Http\Transformers\V0\StatusEffectTransformer;

class ItemStatusEffectController extends RelationalResourceController
{
    /**
     * Create a new ItemStatusEffectController instance.
     *
     * @param ItemService             $itemService             The Service that will process the request
     * @param StatusEffectTransformer $statusEffectTransformer The Transformer that will standardize the response
     */
    public function __construct(ItemService $itemService, StatusEffectTransformer $statusEffectTransformer)
    {
        $this->service = $itemService;
        $this->transformer = $statusEffectTransformer;
        $this->relation = 'statusEffects';
    }
}

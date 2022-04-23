<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\ItemService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\ItemTransformer;

class ItemController extends ResourceController
{
    /**
     * Create a new ItemController instance.
     *
     * @param ItemService     $itemService     The Service that will process the request
     * @param ItemTransformer $itemTransformer The Transformer that will standardize the response
     */
    public function __construct(ItemService $itemService, ItemTransformer $itemTransformer)
    {
        $this->service = $itemService;
        $this->transformer = $itemTransformer;
    }
}

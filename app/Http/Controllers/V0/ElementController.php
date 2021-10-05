<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\ElementService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\ElementTransformer;
use Illuminate\Http\Request;

class ElementController extends ResourceController
{
    /**
     * Create a new ElementController instance.
     *
     * @param ElementService     $elementService     The Service that will process the request
     * @param ElementTransformer $elementTransformer The Transformer that will standardize the response
     */
    public function __construct(ElementService $elementService, ElementTransformer $elementTransformer)
    {
        $this->service = $elementService;
        $this->transformer = $elementTransformer;
    }
}

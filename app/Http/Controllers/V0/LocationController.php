<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\LocationService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\LocationTransformer;

class LocationController extends ResourceController
{
    /**
     * Create a new LocationController instance.
     *
     * @param LocationService     $locationService     The Service that will process the request
     * @param LocationTransformer $locationTransformer The Transformer that will standardize the response
     */
    public function __construct(LocationService $locationService, LocationTransformer $locationTransformer)
    {
        $this->service = $locationService;
        $this->transformer = $locationTransformer;
    }
}

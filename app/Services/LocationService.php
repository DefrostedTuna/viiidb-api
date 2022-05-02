<?php

namespace App\Services;

use App\Contracts\Services\LocationService as LocationServiceContract;
use App\Models\Location;

class LocationService extends ModelService implements LocationServiceContract
{
    /**
     * Create a new LocationService instance.
     *
     * @param Location $model The instance of the model to use for the service
     */
    public function __construct(Location $model)
    {
        $this->model = $model;
    }
}

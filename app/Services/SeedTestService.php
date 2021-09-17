<?php

namespace App\Services;

use App\Contracts\Services\SeedTestService as SeedTestServiceContract;
use App\Models\SeedTest;

class SeedTestService extends ModelService implements SeedTestServiceContract
{
    /**
     * Create a new SeedTestService instance.
     *
     * @param SeedTest $model The instance of the model to use for the service
     */
    public function __construct(SeedTest $model)
    {
        $this->model = $model;
    }
}

<?php

namespace App\Services;

use App\Contracts\Services\SeedRankService as SeedRankServiceContract;
use App\Models\SeedRank;

class SeedRankService extends ModelService implements SeedRankServiceContract
{
    /**
     * Create a new SeedRankService instance.
     *
     * @param SeedRank $model The instance of the model to use for the service
     */
    public function __construct(SeedRank $model)
    {
        $this->model = $model;
    }
}

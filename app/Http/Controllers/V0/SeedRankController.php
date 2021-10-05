<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\SeedRankService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\SeedRankTransformer;
use Illuminate\Http\Request;

class SeedRankController extends ResourceController
{
    /**
     * Create a new SeedRankController instance.
     *
     * @param SeedRankService     $seedRankService     The Service that will process the request
     * @param SeedRankTransformer $seedRankTransformer The Transformer that will standardize the response
     */
    public function __construct(SeedRankService $seedRankService, SeedRankTransformer $seedRankTransformer)
    {
        $this->service = $seedRankService;
        $this->transformer = $seedRankTransformer;
    }
}

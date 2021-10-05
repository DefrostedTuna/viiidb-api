<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\SeedTestService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\SeedTestTransformer;
use Illuminate\Http\Request;

class SeedTestController extends ResourceController
{
    /**
     * Create a new SeedTestController instance.
     *
     * @param SeedTestService     $seedTestService     The Service that will process the request
     * @param SeedTestTransformer $seedTestTransformer The Transformer that will standardize the response
     */
    public function __construct(SeedTestService $seedTestService, SeedTestTransformer $seedTestTransformer)
    {
        $this->service = $seedTestService;
        $this->transformer = $seedTestTransformer;
    }
}

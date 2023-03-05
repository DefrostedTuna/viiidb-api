<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\SeedTestService;
use App\Http\Controllers\RelationalResourceController;
use App\Http\Transformers\V0\TestQuestionTransformer;

class SeedTestTestQuestionController extends RelationalResourceController
{
    /**
     * Create a new SeedTestTestQuestionController instance.
     *
     * @param SeedTestService         $seedTestService         The Service that will process the request
     * @param TestQuestionTransformer $testQuestionTransformer The Transformer that will standardize the response
     */
    public function __construct(SeedTestService $seedTestService, TestQuestionTransformer $testQuestionTransformer)
    {
        $this->service = $seedTestService;
        $this->transformer = $testQuestionTransformer;
        $this->relation = 'testQuestions';
    }
}

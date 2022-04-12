<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\TestQuestionService;
use App\Http\Controllers\ResourceController;
use App\Http\Transformers\V0\TestQuestionTransformer;

class TestQuestionController extends ResourceController
{
    /**
     * Create a new TestQuestionController instance.
     *
     * @param TestQuestionService     $testQuestionService     The Service that will process the request
     * @param TestQuestionTransformer $testQuestionTransformer The Transformer that will standardize the response
     */
    public function __construct(TestQuestionService $testQuestionService, TestQuestionTransformer $testQuestionTransformer)
    {
        $this->service = $testQuestionService;
        $this->transformer = $testQuestionTransformer;
    }
}

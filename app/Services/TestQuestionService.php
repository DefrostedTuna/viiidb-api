<?php

namespace App\Services;

use App\Contracts\Services\TestQuestionService as TestQuestionServiceContract;
use App\Models\TestQuestion;

class TestQuestionService extends ModelService implements TestQuestionServiceContract
{
    /**
     * Create a new TestQuestionService instance.
     *
     * @param TestQuestion $model The instance of the model to use for the service
     */
    public function __construct(TestQuestion $model)
    {
        $this->model = $model;
    }
}

<?php

namespace App\Services;

use App\Contracts\Services\TestQuestionService as TestQuestionServiceContract;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TestQuestionService implements TestQuestionServiceContract
{
    /**
     * The instance of the model to use for the service.
     *
     * @var TestQuestion
     */
    protected $model;

    /**
     * Create a new TestQuestionService instance.
     *
     * @param TestQuestion $model The instance of the model to use for the service
     */
    public function __construct(TestQuestion $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all of the records in the database.
     *
     * @param Request $request The HTTP request from the client
     *
     * @return array
     */
    public function all(Request $request): array
    {
        $query = $this->model->newQuery();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $includes = $this->model->parseIncludes(
            $request->include ?: ''
        );

        $results = $query->with($includes)
            ->filter($request->query())
            ->get();

        return $results->toArray();
    }

    /**
     * Retrieve a specific record from the database, or fail if a record was not found.
     *
     * @param string  $testQuestionId The ID of the requested TestQuestion
     * @param Request $request        The HTTP request from the client
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function findOrFail(string $testQuestionId, Request $request): array
    {
        $includes = $this->model->parseIncludes(
            $request->include ?: ''
        );

        $data = $this->model
            ->with($includes)
            ->where($this->model->getKeyName(), $testQuestionId)
            ->orWhere($this->model->getRouteKeyName(), $testQuestionId)
            ->first();

        if (! $data) {
            throw new NotFoundHttpException('The requested record could not be found.');
        }

        return $data->toArray();
    }
}

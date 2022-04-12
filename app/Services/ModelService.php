<?php

namespace App\Services;

use App\Contracts\Services\ModelService as ModelServiceContract;
use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModelService implements ModelServiceContract
{
    /**
     * The instance of the model to use for the service.
     *
     * @var Model
     */
    protected $model;

    /**
     * Retrieve all of the records in the database.
     *
     * @param Request $request The HTTP request from the client
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(Request $request): array
    {
        $query = $this->getNewQueryBuilderInstance();

        $includes = $this->model->parseIncludes(
            $request->include ?: ''
        );

        $results = $query->with($includes)->get();

        return $results->toArray();
    }

    /**
     * Retrieve a specific record from the database, or fail if a record was not found.
     *
     * @param string  $id      The ID of the requested resource
     * @param Request $request The HTTP request from the client
     *
     * @throws NotFoundHttpException
     *
     * @return array<string, mixed>
     */
    public function findOrFail(string $id, Request $request): array
    {
        $includes = $this->model->parseIncludes(
            $request->include ?: ''
        );

        $data = $this->model
            ->with($includes)
            ->where($this->model->getKeyName(), $id)
            ->orWhere($this->model->getRouteKeyName(), $id)
            ->first();

        if (! $data) {
            throw new NotFoundHttpException('The requested record could not be found.');
        }

        return $data->toArray();
    }

    /**
     * Create a new query builder instance.
     *
     * @return Builder<Model>
     */
    protected function getNewQueryBuilderInstance(): Builder
    {
        return $this->model->newQuery();
    }
}

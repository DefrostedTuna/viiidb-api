<?php

namespace App\Services;

use App\Contracts\Services\ModelService as ModelServiceContract;
use App\Models\Model;
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
     * @param string  $id      The ID of the requested resource
     * @param Request $request The HTTP request from the client
     *
     * @throws NotFoundHttpException
     *
     * @return array
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
}

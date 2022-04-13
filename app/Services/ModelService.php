<?php

namespace App\Services;

use App\Contracts\Services\ModelService as ModelServiceContract;
use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
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
     * @param array<int, string> $includes The relations to include on the resource
     *
     * @return array<int, array<string, mixed>>
     */
    public function all(array $includes = []): array
    {
        $query = $this->getNewQueryBuilderInstance();

        $results = $query->with(
            $this->model->verifyIncludes($includes)
        )->get();

        return $results->toArray();
    }

    /**
     * Retrieve a specific record from the database, or fail if a record was not found.
     *
     * @param string             $id       The ID of the requested resource
     * @param array<int, string> $includes The relations to include on the resource
     *
     * @throws NotFoundHttpException
     *
     * @return array<string, mixed>
     */
    public function findOrFail(string $id, array $includes = []): array
    {
        $data = $this->model
            ->with(
                $this->model->verifyIncludes($includes)
            )
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

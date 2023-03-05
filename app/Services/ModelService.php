<?php

namespace App\Services;

use App\Contracts\Services\ModelService as ModelServiceContract;
use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        $query = $this->getNewQueryBuilderInstance($this->model);

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
     * Retrieve the specified relation through the parent record, or fail if the parent record was not found.
     *
     * @param string             $id       The ID of the requested resource
     * @param string             $relation The relation to load on the resource
     * @param array<int, string> $includes The relations to include on the resource
     *
     * @return array<int, array<string, mixed>>
     */
    public function findRelationOrFail(string $id, string $relation, array $includes = []): array
    {
        $related = $this->getRelatedInstance($relation);

        $data = $this->model
            ->with(array_map(
                // Bypass the depth limit by prefixing the requested includes.
                fn ($item) => "{$relation}.{$item}",
                $related->verifyIncludes($includes)
            ))
            ->where($this->model->getKeyName(), $id)
            ->orWhere($this->model->getRouteKeyName(), $id)
            ->first();

        if (! $data) {
            throw new NotFoundHttpException('The requested record could not be found.');
        }

        return $data->{$relation}->toArray();
    }

    /**
     * Create a new query builder instance.
     *
     * @param Model $model The model instance for which to create a new query builder
     *
     * @return Builder<Model>
     */
    protected function getNewQueryBuilderInstance(Model $model): Builder
    {
        return $model->newQuery();
    }

    /**
     * Create a new instance of the related model.
     *
     * @param string $relation The name of the relation to instantiate
     *
     * @return Model<EloquentModel>
     */
    protected function getRelatedInstance(string $relation): Model
    {
        /** @var Relation */
        $relation = $this->model->{$relation}();

        return $relation->getRelated();
    }
}

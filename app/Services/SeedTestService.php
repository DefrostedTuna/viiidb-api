<?php

namespace App\Services;

use App\Contracts\Services\SeedTestService as SeedTestServiceContract;
use App\Models\SeedTest;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SeedTestService implements SeedTestServiceContract
{
    /**
     * The instance of the model to use for the service.
     *
     * @var SeedTest
     */
    protected $model;

    /**
     * Create a new SeedTestService instance.
     *
     * @param SeedTest $model The instance of the model to use for the service
     */
    public function __construct(SeedTest $model)
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
     * @param string  $seedTestId The ID of the requested SeedTest
     * @param Request $request    The HTTP request from the client
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function findOrFail(string $seedTestId, Request $request): array
    {
        $includes = $this->model->parseIncludes(
            $request->include ?: ''
        );

        $data = $this->model
            ->with($includes)
            ->where($this->model->getKeyName(), $seedTestId)
            ->orWhere($this->model->getRouteKeyName(), $seedTestId)
            ->first();

        if (! $data) {
            throw new NotFoundHttpException('The requested record could not be found.');
        }

        return $data->toArray();
    }
}
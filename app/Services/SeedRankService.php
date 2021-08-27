<?php

namespace App\Services;

use App\Contracts\Services\SeedRankService as SeedRankServiceContract;
use App\Models\SeedRank;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SeedRankService implements SeedRankServiceContract
{
    /**
     * The instance of the model to use for the service.
     *
     * @var SeedRank
     */
    protected $model;

    /**
     * Create a new SeedRankService instance.
     *
     * @param SeedRank $model The instance of the model to use for the service
     */
    public function __construct(SeedRank $model)
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
        $query = $this->model->newModelQuery();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        return $query->filter($request->query())
            ->orderBy(
                $this->model->getOrderByField(),
                $this->model->getOrderByDirection()
            )
            ->get()
            ->toArray();
    }

    /**
     * Retrieve a specific record from the database, or fail if a record was not found.
     *
     * @param string  $seedRankId The ID of the requested SeedRank
     * @param Request $request    The HTTP request from the client
     *
     * @throws NotFoundHttpException
     *
     * @return array
     */
    public function findOrFail(string $seedRankId, Request $request): array
    {
        $data = $this->model
            ->where($this->model->getKeyName(), $seedRankId)
            ->orWhere($this->model->getRouteKeyName(), $seedRankId)
            ->first();

        if (! $data) {
            throw new NotFoundHttpException('The requested record could not be found.');
        }

        return $data->toArray();
    }
}

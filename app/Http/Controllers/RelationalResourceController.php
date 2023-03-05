<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ModelService;
use App\Contracts\Transformers\RecordTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RelationalResourceController extends Controller
{
    use ApiResponse;

    /**
     * Instance of the ModelService.
     *
     * @var ModelService
     */
    protected $service;

    /**
     * Instance of the RecordTransformer.
     *
     * @var RecordTransformer
     */
    protected $transformer;

    /**
     * The relation to load on the resource.
     *
     * @var string
     */
    protected $relation;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request The HTTP request from the client
     * @param string  $id      The ID of the requested record
     *
     * @return JsonResponse
     */
    public function index(Request $request, string $id): JsonResponse
    {
        $records = $this->service->findRelationOrFail(
            $id,
            $this->relation,
            $request->get('include', [])
        );

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->transformer->transformCollection($records)
        );
    }
}

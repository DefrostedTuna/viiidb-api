<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ModelService;
use App\Contracts\Transformers\RecordTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResourceController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request The HTTP request from the client
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $records = $this->service->all($request->get('include', []));

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->transformer->transformCollection($records)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request The HTTP request from the client
     * @param string  $id      The ID of the requested record
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $id): JsonResponse
    {
        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->transformer->transformRecord(
                $this->service->findOrFail($id, $request->get('include', []))
            )
        );
    }
}

<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\SeedRankService;
use App\Http\Controllers\Controller;
use App\Http\Transformers\V0\SeedRankTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeedRankController extends Controller
{
    use ApiResponse;

    /**
     * Instance of the SeedRankService.
     *
     * @var SeedRankService
     */
    protected $seedRankService;

    /**
     * Instance of the SeedRankTransformer.
     *
     * @var SeedRankTransformer
     */
    protected $seedRankTransformer;

    /**
     * Create a new SeedRankController instance.
     *
     * @param SeedRankService     $seedRankService     The Service that will process the request
     * @param SeedRankTransformer $seedRankTransformer The Transformer that will standardize the response
     */
    public function __construct(SeedRankService $seedRankService, SeedRankTransformer $seedRankTransformer)
    {
        $this->seedRankService = $seedRankService;
        $this->seedRankTransformer = $seedRankTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request The HTTP request from the client
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $records = $this->seedRankService->all($request);

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->seedRankTransformer->transformCollection($records)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request    The HTTP request from the client
     * @param string  $seedRankId The ID of the requested SeedRank
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $seedRankId): JsonResponse
    {
        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->seedRankTransformer->transformRecord(
                $this->seedRankService->findOrFail($seedRankId, $request)
            )
        );
    }
}

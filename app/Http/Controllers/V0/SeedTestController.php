<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\SeedTestService;
use App\Http\Controllers\Controller;
use App\Http\Transformers\V0\SeedTestTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeedTestController extends Controller
{
    use ApiResponse;

    /**
     * Instance of the SeedTestService.
     *
     * @var SeedTestService
     */
    protected $seedTestService;

    /**
     * Instance of the SeedTestTransformer.
     *
     * @var SeedTestTransformer
     */
    protected $seedTestTransformer;

    /**
     * Create a new SeedTestController instance.
     *
     * @param SeedTestService     $seedTestService     The Service that will process the request
     * @param SeedTestTransformer $seedTestTransformer The Transformer that will standardize the response
     */
    public function __construct(SeedTestService $seedTestService, SeedTestTransformer $seedTestTransformer)
    {
        $this->seedTestService = $seedTestService;
        $this->seedTestTransformer = $seedTestTransformer;
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
        $records = $this->seedTestService->all($request);

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->seedTestTransformer->transformCollection($records)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request    The HTTP request from the client
     * @param string  $seedTestId The ID of the requested SeedTest
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $seedTestId): JsonResponse
    {
        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->seedTestTransformer->transformRecord(
                $this->seedTestService->findOrFail($seedTestId, $request)
            )
        );
    }
}

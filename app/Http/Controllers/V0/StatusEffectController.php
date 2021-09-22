<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\StatusEffectService;
use App\Http\Controllers\Controller;
use App\Http\Transformers\V0\StatusEffectTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusEffectController extends Controller
{
    use ApiResponse;

    /**
     * Instance of the StatusEffectService.
     *
     * @var StatusEffectService
     */
    protected $statusEffectService;

    /**
     * Instance of the StatusEffectTransformer.
     *
     * @var StatusEffectTransformer
     */
    protected $statusEffectTransformer;

    /**
     * Create a new StatusEffectController instance.
     *
     * @param StatusEffectService     $statusEffectService     The Service that will process the request
     * @param StatusEffectTransformer $statusEffectTransformer The Transformer that will standardize the response
     */
    public function __construct(StatusEffectService $statusEffectService, StatusEffectTransformer $statusEffectTransformer)
    {
        $this->statusEffectService = $statusEffectService;
        $this->statusEffectTransformer = $statusEffectTransformer;
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
        $records = $this->statusEffectService->all($request);

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->statusEffectTransformer->transformCollection($records)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request        The HTTP request from the client
     * @param string  $statusEffectId The ID of the requested StatusEffect
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $statusEffectId): JsonResponse
    {
        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->statusEffectTransformer->transformRecord(
                $this->statusEffectService->findOrFail($statusEffectId, $request)
            )
        );
    }
}

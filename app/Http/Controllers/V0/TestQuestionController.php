<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\TestQuestionService;
use App\Http\Controllers\Controller;
use App\Http\Transformers\V0\TestQuestionTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestQuestionController extends Controller
{
    use ApiResponse;

    /**
     * Instance of the TestQuestionService.
     *
     * @var TestQuestionService
     */
    protected $testQuestionService;

    /**
     * Instance of the TestQuestionTransformer.
     *
     * @var TestQuestionTransformer
     */
    protected $testQuestionTransformer;

    /**
     * Create a new TestQuestionController instance.
     *
     * @param TestQuestionService     $testQuestionService     The Service that will process the request
     * @param TestQuestionTransformer $testQuestionTransformer The Transformer that will standardize the response
     */
    public function __construct(TestQuestionService $testQuestionService, TestQuestionTransformer $testQuestionTransformer)
    {
        $this->testQuestionService = $testQuestionService;
        $this->testQuestionTransformer = $testQuestionTransformer;
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
        $records = $this->testQuestionService->all($request);

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->testQuestionTransformer->transformCollection($records)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request        The HTTP request from the client
     * @param string  $testQuestionId The ID of the requested TestQuestion
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $testQuestionId): JsonResponse
    {
        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->testQuestionTransformer->transformRecord(
                $this->testQuestionService->findOrFail($testQuestionId, $request)
            )
        );
    }
}

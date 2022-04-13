<?php

namespace App\Http\Controllers\V0;

use App\Contracts\Services\Search\SearchService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchFormRequest;
use App\Http\Transformers\V0\SearchTransformer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    use ApiResponse;

    /**
     * Instance of the SearchService.
     *
     * @var SearchService
     */
    protected $service;

    /**
     * Instance of the SearchTransformer.
     *
     * @var SearchTransformer
     */
    protected $transformer;

    /**
     * Create a new SearchController instance.
     *
     * @param SearchService     $searchService     The Service that will process the request
     * @param SearchTransformer $searchTransformer The Transformer that will standardize the response
     */
    public function __construct(SearchService $searchService, SearchTransformer $searchTransformer)
    {
        $this->service = $searchService;
        $this->transformer = $searchTransformer;
    }

    /**
     * Search the system for a subset of records.
     *
     * @param SearchFormRequest $request The HTTP request from the client
     *
     * @return JsonResponse
     */
    public function index(SearchFormRequest $request): JsonResponse
    {
        $query = $request->get('q');
        $only = $request->get('only', []);
        $exclude = $request->get('exclude', []);

        $records = $this->service->search($query, $only, $exclude);

        return $this->respondWithSuccess(
            'Successfully retrieved data.',
            $this->transformer->transformSearchResults($records)
        );
    }
}

<?php

namespace App\Http\Controllers\V0;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class HealthCheckController extends Controller
{
    use ApiResponse;

    /**
     * Check the server's status.
     *
     * @return JsonResponse
     */
    public function status(): JsonResponse
    {
        $baseUrl = config('app.url');
        $currentApiVersion = config('app.current_api_version');

        return $this->respondWithSuccess('VIIIDB API is running.', [
            'message' => 'VIIIDB API is currently under construction and is subject to frequent major changes. The following resources are currently available for consumption.',
            'resources' => [
                'search' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/search",
                    'query_parameters' => [
                        'q' => [
                            'description' => 'The search query.',
                            'options' => [],
                        ],
                        'only' => [
                            'description' => 'A comma separated list of resources to search. Options may be formatted as camelCase, snake_case, or kebab-case.',
                            'options' => ['seed-ranks', 'seed-tests', 'test-questions', 'status-effects', 'elements'],
                        ],
                        'exclude' => [
                            'description' => 'A comma separated list of resources to exclude from search results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                            'options' => ['seed-ranks', 'seed-tests', 'test-questions', 'status-effects', 'elements'],
                        ],
                    ],
                ],
                'seed_ranks' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks",
                    'query_parameters' => [],
                ],
                'seed_tests' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/seed-tests",
                    'query_parameters' => [
                        'include' => [
                            'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                            'options' => ['test-questions'],
                        ],
                    ],
                ],
                'test_questions' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/test-questions",
                    'query_parameters' => [
                        'include' => [
                            'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                            'options' => ['seed-test'],
                        ],
                    ],
                ],
                'status_effects' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/status-effects",
                    'query_parameters' => [],
                ],
                'elements' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/elements",
                    'query_parameters' => [],
                ],
                'items' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/items",
                    'query_parameters' => [],
                ],
                'locations' => [
                    'url' => "{$baseUrl}/v{$currentApiVersion}/locations",
                    'query_parameters' => [
                        'include' => [
                            'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                            'options' => [
                                'region',
                                'parent',
                                'locations',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}

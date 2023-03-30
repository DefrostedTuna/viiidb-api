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
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/search",
                        'url_parameters' => [],
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
                ],
                'seed_ranks' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks",
                        'url_parameters' => [],
                        'query_parameters' => [],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks/{seed-rank}",
                        'url_parameters' => [
                            '{seed-rank}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'rank'],
                            ],
                        ],
                        'query_parameters' => [],
                    ],
                ],
                'seed_tests' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-tests",
                        'url_parameters' => [],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['test-questions'],
                            ],
                        ],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-tests/{seed-test}",
                        'url_parameters' => [
                            '{seed-test}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'level'],
                            ],
                        ],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['test-questions'],
                            ],
                        ],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-tests/{seed-test}/test-questions",
                        'url_parameters' => [
                            '{seed-test}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'level'],
                            ],
                        ],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['seed-test'],
                            ],
                        ],
                    ],
                ],
                'test_questions' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/test-questions",
                        'url_parameters' => [],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['seed-test'],
                            ],
                        ],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/test-questions/{test-question}",
                        'url_parameters' => [
                            '{test-question}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id'],
                            ],
                        ],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['seed-test'],
                            ],
                        ],
                    ],
                ],
                'status_effects' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/status-effects",
                        'url_parameters' => [],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['items'],
                            ],
                        ],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/status-effects/{status-effect}",
                        'url_parameters' => [
                            '{status-effect}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'name'],
                            ],
                        ],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['items'],
                            ],
                        ],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/status-effects/{status-effect}/items",
                        'url_parameters' => [
                            '{status-effect}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'name'],
                            ],
                        ],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['status-effects'],
                            ],
                        ],
                    ],
                ],
                'elements' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/elements",
                        'url_parameters' => [],
                        'query_parameters' => [],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/elements/{element}",
                        'url_parameters' => [
                            '{element}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'name'],
                            ],
                        ],
                        'query_parameters' => [],
                    ],
                ],
                'items' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/items",
                        'url_parameters' => [],
                        'query_parameters' => [],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/items/{item}",
                        'url_parameters' => [
                            '{item}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'slug'],
                            ],
                        ],
                        'query_parameters' => [],
                    ],
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/items/{item}/status-effects",
                        'url_parameters' => [
                            '{item}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'slug'],
                            ],
                        ],
                        'query_parameters' => [
                            'include' => [
                                'description' => 'Include the specified relations with the results. Options may be formatted as camelCase, snake_case, or kebab-case.',
                                'options' => ['items'],
                            ],
                        ],
                    ],
                ],
                'locations' => [
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/locations",
                        'url_parameters' => [],
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
                    [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/locations/{location}/locations",
                        'url_parameters' => [
                            '{location}' => [
                                'description' => 'The unique identifier associated with the record. Options indicate the keys on the record where the associated value may be used as the identifier.',
                                'options' => ['id', 'slug'],
                            ],
                        ],
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
            ],
        ]);
    }
}

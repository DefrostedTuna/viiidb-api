<?php

namespace Tests\Feature\Endpoints\V0;

use Tests\TestCase;

class HealthCheckEndpointTest extends TestCase
{
    /** @test */
    public function it_can_check_the_server_status(): void
    {
        $this->withoutMiddleware();

        $baseUrl = config('app.url');
        $currentApiVersion = config('app.current_api_version');

        $response = $this->get('/v0');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'VIIIDB API is running.',
            'status_code' => 200,
            'data' => [
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
                ],
            ],
        ]);
    }
}

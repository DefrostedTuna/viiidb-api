<?php

namespace Tests\Unit\Controllers\V0;

use App\Http\Controllers\V0\HealthCheckController;
use Tests\TestCase;

class HealthCheckControllerTest extends TestCase
{
    /** @test */
    public function it_can_check_the_server_status(): void
    {
        $baseUrl = config('app.url');
        $currentApiVersion = config('app.current_api_version');

        $controller = new HealthCheckController();
        $response = $controller->status();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArraySubset([
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
                                'description' => 'A comma separated list of resources to search.',
                                'options' => ['seed_ranks', 'seed_tests', 'test_questions', 'status_effects', 'elements'],
                            ],
                            'exclude' => [
                                'description' => 'A comma separated list of resources to exclude from search results.',
                                'options' => ['seed_ranks', 'seed_tests', 'test_questions', 'status_effects', 'elements'],
                            ],
                        ],
                    ],
                    'seed_ranks' => [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks",
                        'query_parameters' => [],
                    ],
                    'seed_tests' => [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/seed-tests",
                        'query_parameters' => [],
                    ],
                    'test_questions' => [
                        'url' => "{$baseUrl}/v{$currentApiVersion}/test-questions",
                        'query_parameters' => [],
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
        ], $response->getData(true));
    }
}

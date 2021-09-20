<?php

namespace Tests\Feature\Endpoints\V0;

use Tests\TestCase;

class HealthCheckEndpointTest extends TestCase
{
    /** @test */
    public function it_can_check_the_server_status()
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
                    'seed_ranks' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks",
                    'seed_tests' => "{$baseUrl}/v{$currentApiVersion}/seed-tests",
                    'test_questions' => "{$baseUrl}/v{$currentApiVersion}/test-questions",
                ],
            ],
        ]);
    }
}

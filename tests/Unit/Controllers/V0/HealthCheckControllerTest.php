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
                    'seed_ranks' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks",
                ],
            ],
        ], $response->getData(true));
    }
}

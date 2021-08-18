<?php

namespace Tests\Unit\V0\Controllers;

use App\Http\Controllers\Api\V0\HealthCheckController;
use Tests\TestCase;

class HealthCheckControllerTest extends TestCase
{
    /** @test */
    public function it_can_check_the_server_status()
    {
        $controller = new HealthCheckController();
        $response = $controller->status();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArraySubset([
            'success' => true,
            'message' => 'OK',
            'status_code' => 200,
            'data' => null,
        ], $response->getData(true));
    }
}

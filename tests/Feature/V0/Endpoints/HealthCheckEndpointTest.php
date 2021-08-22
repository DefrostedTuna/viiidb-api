<?php

namespace Tests\Feature\V0\Endpoints;

use Tests\TestCase;

class HealthCheckEndpointTest extends TestCase
{
    /** @test */
    public function it_can_check_the_server_status()
    {
        $response = $this->get('api/v0/');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'OK',
            'status_code' => 200,
            'data' => null,
        ]);
    }
}

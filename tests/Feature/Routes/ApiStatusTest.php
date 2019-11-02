<?php

namespace Tests\Feature\Routes;

use Tests\TestCase;

class ApiStatusTest extends TestCase
{
    /** @test */
    public function it_checks_the_status_of_the_api()
    {
        $response = $this->get('/api/status');

        $response->assertStatus(200);
        $response->assertSee('OK');
    }
}

<?php

namespace Tests\Feature\Middleware;

use App\Contracts\Services\SeedRankService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaptureInboundRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_capture_successful_requests(): void
    {
        $this->get('/v0/seed-ranks');

        $this->assertDatabaseCount('inbound_requests', 1);
    }

    /** @test */
    public function it_will_capture_unsuccessful_requests(): void
    {
        $mockedService = $this->mock(SeedRankService::class, function ($mock) {
            $mock->shouldReceive('all')->andThrow(new Exception('Something'));
        });
        $this->app->instance(SeedRankService::class, $mockedService);

        $this->get('/v0/seed-ranks');

        $this->assertDatabaseCount('inbound_requests', 1);
    }

    /** @test */
    public function it_will_not_capture_404_requests(): void
    {
        $this->get('/invalid-endpoint');

        $this->assertDatabaseCount('inbound_requests', 0);
    }
}

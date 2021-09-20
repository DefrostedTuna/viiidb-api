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
    public function it_will_record_successful_requests()
    {
        $this->get('/v0/seed-ranks');

        $this->assertDatabaseCount('inbound_requests', 1);
    }

    /** @test */
    public function it_will_record_unsuccessful_requests()
    {
        $mockedService = $this->mock(SeedRankService::class, function ($mock) {
            $mock->shouldReceive('all')->andThrow(new Exception('Something'));
        });
        $this->app->instance(SeedRankService::class, $mockedService);

        $this->get('/v0/seed-ranks');

        $this->assertDatabaseCount('inbound_requests', 1);
    }

    /** @test */
    public function it_will_not_record_404_requests()
    {
        $this->get('/invalid-endpoint');

        $this->assertDatabaseCount('inbound_requests', 0);
    }
}

<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\CaptureInboundRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class CaptureInboundRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_will_capture_successful_requests(): void
    {
        $request = new Request();
        $response = new JsonResponse([], 200);
        $middleware = new CaptureInboundRequest();

        $middleware->handle($request, function () {});
        $middleware->terminate($request, $response);

        /*
         * The 'duration' field will also be present within the request.
         * However, we can't easily test for this.
         */
        $this->assertDatabaseCount('inbound_requests', 1);
        $this->assertDatabaseHas('inbound_requests', [
            'ip_address' => $request->getClientIp(),
            'user_agent' => $request->userAgent(),
            'api_version' => $request->route() ? $request->route()->getPrefix() : null,
            'path' => $request->getPathInfo(),
            'query_string' => $request->getQueryString(),
            'full_path' => $request->getRequestUri(),
            'full_uri' => $request->getUri(),
            'headers' => json_encode($request->headers->all()),
            'status_code' => $response->getStatusCode(),
        ]);
    }

    /** @test */
    public function it_will_capture_unsuccessful_requests(): void
    {
        $request = new Request();
        $response = new JsonResponse([], 500);
        $middleware = new CaptureInboundRequest();

        $middleware->handle($request, function () {});
        $middleware->terminate($request, $response);

        /*
         * The 'duration' field will also be present within the request.
         * However, we can't easily test for this.
         */
        $this->assertDatabaseCount('inbound_requests', 1);
        $this->assertDatabaseHas('inbound_requests', [
            'ip_address' => $request->getClientIp(),
            'user_agent' => $request->userAgent(),
            'api_version' => $request->route() ? $request->route()->getPrefix() : null,
            'path' => $request->getPathInfo(),
            'query_string' => $request->getQueryString(),
            'full_path' => $request->getRequestUri(),
            'full_uri' => $request->getUri(),
            'headers' => json_encode($request->headers->all()),
            'status_code' => $response->getStatusCode(),
        ]);
    }
}

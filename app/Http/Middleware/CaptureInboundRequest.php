<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class CaptureInboundRequest
{
    protected $startTime = 0;

    /**
     * Handle an incoming request.
     *
     * @param Request $request The HTTP request from the client
     * @param Closure $next    The next middleware in the chain
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->startTime = microtime(true);

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param Request      $request  The HTTP request from the client
     * @param JsonResponse $response The response sent back to the client
     *
     * @return void
     */
    public function terminate(Request $request, JsonResponse $response)
    {
        $endTime = microtime(true);
        $timeInMilliseconds = number_format($endTime - $this->startTime, 3) * 1000;

        DB::table('inbound_requests')->insert([
            'id' => Uuid::generate(4),
            'ip_address' => $request->getClientIp(),
            'user_agent' => $request->userAgent(),
            'api_version' => $request->route() ? $request->route()->getPrefix() : null,
            'path' => $request->getPathInfo(),
            'query_string' => $request->getQueryString(),
            'full_path' => $request->getRequestUri(),
            'full_uri' => $request->getUri(),
            'headers' => json_encode($request->headers->all()),
            'status_code' => $response->getStatusCode(),
            'duration' => $timeInMilliseconds,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

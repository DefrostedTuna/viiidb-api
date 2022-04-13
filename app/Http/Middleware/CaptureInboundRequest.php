<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class CaptureInboundRequest
{
    /**
     * The time at which the request was first processed.
     *
     * @var float
     */
    protected $startTime = 0;

    /**
     * Handle an incoming request.
     *
     * @param Request $request The HTTP request from the client
     * @param Closure $next    The next middleware in the chain
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse|Response
    {
        $this->startTime = microtime(true);

        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param Request      $request  The HTTP request from the client
     * @param JsonResponse $response The response sent back to the client
     */
    public function terminate(Request $request, JsonResponse $response): void
    {
        $endTime = microtime(true);
        $timeInMilliseconds = number_format(($endTime - $this->startTime) * 1000, 3);

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

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SanitizesSearchInput
{
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
        if ($request->has('only')) {
            $sanitized = [];
            $resources = explode(',', $request->get('only', ''));

            foreach ($resources as $resource) {
                $sanitized[] = Str::snake(
                    Str::camel($resource)
                );
            }

            $request->merge([
                'only' => $sanitized,
            ]);
        }

        if ($request->has('exclude')) {
            $sanitized = [];
            $resources = explode(',', $request->get('exclude', ''));

            foreach ($resources as $resource) {
                $sanitized[] = Str::snake(
                    Str::camel($resource)
                );
            }

            $request->merge([
                'exclude' => $sanitized,
            ]);
        }

        return $next($request);
    }
}

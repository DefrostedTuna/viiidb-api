<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SanitizesRelationalIncludes
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
        if ($request->has('include')) {
            $sanitized = [];
            $includes = explode(',', $request->get('include', ''));

            foreach ($includes as $include) {
                $sanitized[] = Str::camel($include);
            }

            $request->merge([
                'include' => $sanitized,
            ]);
        }

        return $next($request);
    }
}

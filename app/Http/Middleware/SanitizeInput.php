<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\ParameterBag;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->sanitizeInput($request->request);

        return $next($request);
    }

    /**
     * Converts all values in the request to lowercase equivalents.
     *
     * @param \Symfony\Component\HttpFoundation\ParameterBag $bag
     *
     * @return void
     */
    protected function sanitizeInput(ParameterBag $bag) {
        $sanitized = [];

        foreach ($bag as $key => $value) {
            $lowercaseKey = strtolower($key);
            $lowercaseValue = strtolower($value);

            $sanitized[$lowercaseKey] = $lowercaseValue;
        }

        $bag->replace($sanitized);
    }
}

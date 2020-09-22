<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class EncodeCharacters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $queryString = $request->server->get('QUERY_STRING');
        $requestUri = $request->server->get('REQUEST_URI');

        // We're only looking for `+` characters at the moment.
        $queryString = preg_replace('/\+/', '%2B', $queryString);
        $requestUri = preg_replace('/\+/', '%2B', $requestUri);

        $request->server->set('QUERY_STRING', $queryString);
        $request->server->set('REQUEST_URI', $requestUri);

        parse_str($queryString, $values);
        $this->replaceParameterBagValues($request->request, $values);
        
        $serverValues = array_values((array) $request->server);
        $newRequest = $request->duplicate(
            null,
            null,
            null,
            null,
            null,
            $serverValues[0]
        );

        return $next($newRequest);
    }

    /**
     * Replaces parameters present on the request with the modified values.
     *
     * @param  \Symfony\Component\HttpFoundation\ParameterBag  $bag
     * @param  array                                           $values
     *
     * @return void
     */
    protected function replaceParameterBagValues(ParameterBag $bag, array $values): void
    {
        $newValues = [];

        foreach ($bag as $key => $value) {
            $newValues[$key] = $values[$key];
        }

        $bag->replace($newValues);
    }
}

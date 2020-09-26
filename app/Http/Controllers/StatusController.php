<?php

namespace App\Http\Controllers;

class StatusController extends Controller
{
    /**
     * Returns a 200 'OK' HTTP status code used for Kubernetes health checks.
     * This is placed in a function to enable route caching in production environments.
     *
     * @return string
     */
    public function healthCheck(): string
    {
        return 'OK';
    }
}

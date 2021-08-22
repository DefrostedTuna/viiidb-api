<?php

namespace App\Http\Controllers\V0;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class HealthCheckController extends Controller
{
    use ApiResponse;

    /**
     * Check the server's status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(): JsonResponse
    {
        return $this->respondWithSuccess('OK');
    }
}

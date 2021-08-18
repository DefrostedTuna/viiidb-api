<?php

namespace App\Http\Controllers\Api\V0;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;

class HealthCheckController extends ApiController
{
    /**
     * Check the server's status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(): JsonResponse
    {
        return $this->jsonResponse([
            'success' => true,
            'message' => 'OK',
            'status_code' => 200,
            'data' => null,
        ], 200);
    }
}

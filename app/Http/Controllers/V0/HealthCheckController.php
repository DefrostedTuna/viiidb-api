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
     * @return JsonResponse
     */
    public function status(): JsonResponse
    {
        $baseUrl = config('app.url');
        $currentApiVersion = config('app.current_api_version');

        return $this->respondWithSuccess('VIIIDB API is running.', [
            'message' => 'VIIIDB API is currently under construction and is subject to frequent major changes. The following resources are currently available for consumption.',
            'resources' => [
                'seed_ranks' => "{$baseUrl}/v{$currentApiVersion}/seed-ranks",
            ],
        ]);
    }
}

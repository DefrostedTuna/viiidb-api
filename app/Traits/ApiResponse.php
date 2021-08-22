<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Send a successful JSON response back to the client.
     *
     * @param string     $message    The response message
     * @param mixed|null $data       The response data
     * @param int        $statusCode The response status code
     *
     * @return JsonResponse
     */
    public function respondWithSuccess(string $message, mixed $data = null, int $statusCode = 200): JsonResponse
    {
        return new JsonResponse([
            'success' => true,
            'message' => $message,
            'status_code' => $statusCode,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Send a failure JSON response back to the client.
     *
     * @param string     $message    The error message
     * @param mixed|null $errors     The error data
     * @param int        $statusCode The error status code
     *
     * @return JsonResponse
     */
    public function respondWithError(string $message, mixed $errors = null, int $statusCode = 500): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'message' => $message,
            'status_code' => $statusCode,
            'errors' => $errors,
        ], $statusCode);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Send a JSON response back to the client.
     *
     * @param array $data    The response data
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     * @param int   $options The encoding options for json_encode
     * @param bool  $json    If the data is already a JSON string
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(
        array $data = [],
        int $status = 200,
        array $headers = [],
        int $options = 0,
        bool $json = false
    ): JsonResponse {
        return new JsonResponse($data, $status, $headers, $options, $json);
    }
}

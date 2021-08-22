<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request The HTTP request from the client
     * @param Throwable                $e       The exception that was thrown
     *
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        if ($request->route() && in_array('api', $request->route()->middleware())) {
            $request->headers->set('accept', 'application/json');
        }

        if ($request->wantsJson()) {
            return $this->handleJsonException($e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle the exception and standardize the output for a JSON response.
     *
     * @param Throwable $e The exception that was thrown
     *
     * @return JsonResponse
     */
    protected function handleJsonException(Throwable $e): JsonResponse
    {
        $message = config('app.debug')
            ? $e->getMessage()
            : ($this->isHttpException($e) ? $e->getMessage() : 'Server Error');

        return $this->respondWithError(
            $message,
            $this->convertExceptionToArray($e),
            $this->isHttpException($e) ? $e->getStatusCode() : 500
        );
    }
}

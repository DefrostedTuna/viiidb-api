<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $e The exception that was thrown
     */
    public function report(Throwable $e): void
    {
        if (app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request The HTTP request from the client
     * @param Throwable $e       The exception that was thrown
     *
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        if ($this->requestShouldHaveJsonHeaders($request)) {
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
        $statusCode = 500;
        $errors = $this->convertExceptionToArray($e);
        $message = config('app.debug')
            ? $e->getMessage()
            : ($this->shouldReportPublicMessage($e) ? $e->getMessage() : 'Server Error');

        if ($e instanceof HttpExceptionInterface) {
            $statusCode = $e->getStatusCode();
        }

        if ($e instanceof ValidationException) {
            $statusCode = $e->status;
            $errors = $e->errors();
        }

        return $this->respondWithError(
            $message,
            $errors,
            $statusCode
        );
    }

    /**
     * Determine whether or not the request should have JSON headers.
     *
     * @param Request $request The HTTP request from the client
     *
     * @return bool
     */
    protected function requestShouldHaveJsonHeaders(Request $request): bool
    {
        return $request->route() && in_array('api', (array) $request->route()->middleware());
    }

    /**
     * Determine if the exception should report the message to the user.
     *
     * @param Throwable $e The exception that was thrown
     *
     * @return bool
     */
    protected function shouldReportPublicMessage(Throwable $e): bool
    {
        if ($this->isHttpException($e)) {
            return true;
        }

        if ($e instanceof ValidationException) {
            return true;
        }

        return false;
    }
}

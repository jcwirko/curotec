<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {

            if ($exception instanceof ValidationException) {
               return $this->responseJson([
                    'error' => 'Validation failed',
                    'details' => $exception->errors(),
                ], 422);
            }

            if ($exception instanceof ModelNotFoundException) {
                $model = class_basename($exception->getModel());

                return $this->responseJson("$model Model Not found");
            }

            return $this->responseJson([
                'error' => 'Internal Server Error',
                'message' => config('app.debug') ? $exception->getMessage() : 'Something went wrong.',
            ], 500);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    private function responseJson($message, $statusCode = 404, $data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}

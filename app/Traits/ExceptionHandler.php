<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ExceptionHandler
{
    private function handleException(\Exception $exception): JsonResponse
    {
        ['code' => $code, 'message' => $message] = match (true) {
            $exception instanceof HttpException => [
                'code' => $exception->getStatusCode(),
                'message' => $exception->getMessage(),
            ],
            $exception instanceof QueryException => [
                'code' => 500,
                'message' => $exception->getMessage() ?: 'A query exception has occurred.',
            ],
            $exception instanceof ValidationException => [
                'code' => 422,
                'message' => $exception->getMessage() ?: 'A validation exception has occurred.',
            ],
            $exception instanceof ModelNotFoundException => [
                'code' => 404,
                'message' => $exception->getMessage() ?: 'A given model was not found.',
            ],
            default => [
                'code' => 500,
                'message' => $exception->getMessage(),
            ]
        };

        return response()->json(['errors' => ['message' => $message]], $code);
    }
}

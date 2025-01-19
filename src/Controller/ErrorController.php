<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Formatter\ApiResponseFormatter;

class ErrorController
{
    public function __construct(private ApiResponseFormatter $apiResponseFormatter) {}
    public function show(\Throwable $exception): JsonResponse
    {
        $message = match ($exception->getStatusCode()) {
            404 => 'Resource not found',
            403 => 'Access denied',
            500 => 'Internal server error',
            default => 'An error occurred',
        };

        return $this->apiResponseFormatter
            ->withErrors([$exception->getMessage()])
            ->withoutData()
            ->withStatus($exception->getStatusCode() ?: 500)
            ->withMessage($message)
            ->response();
    }
}

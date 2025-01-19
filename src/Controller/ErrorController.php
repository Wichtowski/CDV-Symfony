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
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        $message = match ($statusCode) {
            404 => 'Resource not found',
            403 => 'Access denied',
            500 => 'Internal server error',
            default => 'An error occurred',
        };

        return $this->apiResponseFormatter
            ->withErrors([$exception->getMessage()])
            ->withoutData()
            ->withStatus($statusCode)
            ->withMessage($message)
            ->response();
    }
}

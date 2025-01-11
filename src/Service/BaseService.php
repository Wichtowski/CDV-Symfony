<?php

declare(strict_types=1);

namespace App\Service;
use Symfony\Component\HttpFoundation\JsonResponse;


class BaseService
{
    public function failResponder(string $message, int $statusCode): JsonResponse
    {
        switch ($statusCode) {
            case 400:
                $errorMessage = 'Bad Request: ' . $message;
                break;
            case 401:
                $errorMessage = 'Unauthorized: ' . $message;
                break;
            case 403:
                $errorMessage = 'Forbidden: ' . $message;
                break;
            case 404:
                $errorMessage = 'Not Found: ' . $message;
                break;
            case 500:
                $errorMessage = 'Internal Server Error: ' . $message;
                break;
            default:
                $errorMessage = $message;
                break;
        }
        return new JsonResponse(['error' => $errorMessage], $statusCode);
    }

    public function successResponder($data): JsonResponse
    {
        return new JsonResponse($data, 200);
    }
}

<?php

declare(strict_types=1);

namespace App\Service;

class BaseService
{
    public function failResponder(string $message, int $statusCode): void
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
        throw new \Exception($errorMessage, $statusCode);
    }

    public function successResponder($data): array
    {
        return ['data' => $data, 'errors' => $error, 'status' => 200];
    }
}

<?php

declare(strict_types=1);

namespace App\Formatter;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseFormatter
{
    private array $data = [];
    private string $message = 'success';
    private array $errors = [];
    private int $status = Response::HTTP_OK;
    private array $additionalData = [];
    private bool $includeData = true;
    private bool $includeAdditionalData = true;

    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function withErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function withStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function withAdditionalData($additionalData): self
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function withoutData(): self
    {
        $this->includeData = false;
        $this->includeAdditionalData = false;

        return $this;
    }

    public function withoutAdditionalData(): self
    {
        $this->includeAdditionalData = false;

        return $this;
    }

    public function response(): JsonResponse
    {
        $response = [];

        if ($this->includeData) {
            $response['data'] = $this->data;
        }

        $response['message'] = $this->message;
        $response['errors'] = $this->errors;
        $response['status'] = $this->status;

        if ($this->includeAdditionalData) {
            $response['additionalData'] = $this->additionalData;
        }

        return new JsonResponse($response, $this->status);
    }
}
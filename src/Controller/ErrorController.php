<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorController
{
    public function show(\Throwable $exception): Response
    {
        $statusCode = $exception instanceof NotFoundHttpException ? 404 : 500;
        $errorStatusCode = __DIR__ . '/../../public/' . $statusCode . '.html';

        if ($statusCode === 404) {
            return new Response(file_get_contents($errorStatusCode), Response::HTTP_NOT_FOUND, ['Content-Type' => 'text/html']);
        }

        return new Response(file_get_contents($errorStatusCode), Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'text/html']);
    }
}



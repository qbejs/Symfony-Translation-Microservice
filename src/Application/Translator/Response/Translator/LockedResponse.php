<?php

namespace App\Application\Translator\Response\Translator;

use App\Application\Translator\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LockedResponse implements ResponseInterface
{
    public static function response(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => 'Nie można przetłumaczyć tekstu, ponieważ jest obecnie przetwarzany.'
        ], Response::HTTP_CONFLICT);  // HTTP 409 Conflict
    }
}
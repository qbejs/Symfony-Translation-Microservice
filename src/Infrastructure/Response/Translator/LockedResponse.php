<?php

namespace App\Infrastructure\Response\Translator;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LockedResponse extends JsonResponse
{
    public function __construct(string $content = null, int $status = Response::HTTP_CONFLICT, array $headers = [])
    {
        parent::__construct([
            'status' => 'error',
            'message' => 'Nie można przetłumaczyć tekstu, ponieważ jest obecnie przetwarzany.',
        ], $status, $headers);
    }
}

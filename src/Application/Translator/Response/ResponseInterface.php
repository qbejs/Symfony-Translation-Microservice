<?php

namespace App\Application\Translator\Response;

use Symfony\Component\HttpFoundation\Response;

interface ResponseInterface
{
    public static function response(): Response;
}

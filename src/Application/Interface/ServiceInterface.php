<?php

namespace App\Application\Interface;

use Symfony\Component\Messenger\Envelope;

interface ServiceInterface
{
    public function getResultFromMessage(Envelope $message): mixed;
}
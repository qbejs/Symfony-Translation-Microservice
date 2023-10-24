<?php

namespace App\Domain\Interface\Notification;

interface SmsProviderInterface
{
    public function isSupported(string $type): bool;

    public function send(string $receiver, string $message): bool;
}

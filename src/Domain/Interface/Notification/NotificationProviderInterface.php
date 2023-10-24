<?php

namespace App\Domain\Interface\Notification;

use App\Domain\Models\NotificationType;

interface NotificationProviderInterface
{
    public function createClient(array $params = []): void;

    public function addReceiver(string $receiver): void;

    public function addSender(string $sender): void;

    public function sendMessage(NotificationType $message, array $params): void;

    public function isSupported(string $type): bool;
}

<?php

namespace App\Infrastructure\EventSubscriber\Backoffice\Notificator\Event;

class DispatchNotificationEvent
{
    public string $notificationName;
    public string $notificationProvider;
    public string $receiver;
    public array $messageParams;

    public function __construct(string $notificationName, string $notificationProvider, string $receiver, array $messageParams)
    {
        $this->notificationName = $notificationName;
        $this->notificationProvider = $notificationProvider;
        $this->receiver = $receiver;
        $this->messageParams = $messageParams;
    }
}

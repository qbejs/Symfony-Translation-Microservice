<?php

namespace App\Application\Backoffice\Notificator\Listener;

use App\Application\Backoffice\Notificator\Event\DispatchNotificationEvent;
use App\Domain\Interface\NotificationTypeRepositoryInterface;
use App\Domain\Models\NotificationType;
use App\Infrastructure\Notifier\NotifierManager;
use App\Infrastructure\Notifier\SupportedNotificationTypesEnum;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'notification.dispatched', method: 'onNotificationDispatched')]
class DispatchNotificationListener
{
    public function __construct(private readonly NotificationTypeRepositoryInterface $notificationTypeRepository, private readonly NotifierManager $notifyManager)
    {
    }

    /**
     * @throws \Exception
     */
    public function onNotificationDispatched(DispatchNotificationEvent $event): void
    {
        $this->notifyManager->send(
            SupportedNotificationTypesEnum::tryFrom($event->notificationProvider),
            $this->getNotificationType($event->notificationName),
            $event->receiver,
            $event->messageParams
        );
    }

    private function getNotificationType($name): ?NotificationType
    {
        return $this->notificationTypeRepository->findByName($name);
    }
}

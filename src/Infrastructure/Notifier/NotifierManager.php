<?php

namespace App\Infrastructure\Notifier;

use App\Domain\Interface\Notification\NotificationProviderInterface;
use App\Domain\Models\NotificationType;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class NotifierManager
{
    private iterable $providers;

    public function __construct(#[TaggedIterator('app.notification.providers')] iterable $providers)
    {
        $this->providers = $providers;
    }

    private function getProvider(string $type): ?NotificationProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->isSupported($type)) {
                return $provider;
            }
        }

        return null;
    }

    public function send(SupportedNotificationTypesEnum $type, NotificationType $notificationType, string $receiver, array $params): bool
    {
        $provider = $this->getProvider($type->value);

        if (!$provider) {
            throw new \Exception('No provider found');
        }

        $provider->addSender('System');
        $provider->addReceiver($receiver);
        $provider->sendMessage($notificationType, $params);

        return true;
    }
}

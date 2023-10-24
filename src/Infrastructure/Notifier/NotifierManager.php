<?php

namespace App\Infrastructure\Notifier;

use App\Domain\Interface\Notification\NotificationProviderInterface;
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
}

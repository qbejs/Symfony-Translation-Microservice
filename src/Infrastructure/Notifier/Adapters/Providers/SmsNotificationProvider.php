<?php

namespace App\Infrastructure\Notifier\Adapters\Providers;

use App\Domain\Interface\Notification\NotificationProviderInterface;
use App\Domain\Interface\Notification\SmsProviderInterface;
use App\Domain\Models\NotificationType;
use App\Infrastructure\Helper\MessageBuilder;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SmsNotificationProvider implements NotificationProviderInterface
{
    private iterable $providers;
    private string $receiver;
    private string $sender;
    private ?SmsProviderInterface $provider = null;

    public function __construct(#[TaggedIterator('app.sms.provider')] iterable $providers, private readonly MessageBuilder $messageBuilder, string $defaultProvider)
    {
        $this->providers = $providers;
        $this->createClient(['type' => $defaultProvider]);
    }

    private function setProvider(string $type): ?SmsProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->isSupported($type)) {
                return $provider;
            }
        }

        return null;
    }

    public function createClient(array $params = []): void
    {
        if (null === $this->provider) {
            $this->provider = $this->setProvider($params['type']);
        }
    }

    public function addReceiver(string $receiver): void
    {
        $this->receiver = $receiver;
    }

    public function addSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendMessage(NotificationType $message, array $params): void
    {
        $text = $this->messageBuilder->build($message, $params);
        if (strlen($text) > 160) {
            $text = substr($text, 0, 160);
        }
        $this->provider->send($this->receiver, $text);
    }

    public function isSupported(string $type): bool
    {
        return 'sms' === $type;
    }
}

<?php

namespace App\Infrastructure\Notifier\Adapters\Providers;

use App\Domain\Interface\Notification\NotificationProviderInterface;
use App\Domain\Models\NotificationType;
use App\Infrastructure\Helper\MessageBuilder;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EmailNotificationProvider implements NotificationProviderInterface
{
    private array $receivers = [];
    private ?string $sender = null;

    public function __construct(private readonly MailerInterface $mailer, private readonly MessageBuilder $messageBuilder)
    {
    }

    public function createClient(array $params = []): void
    {
        return; // Not needed
    }

    public function addReceiver(string $receiver): void
    {
        $this->receivers[] = $receiver;
    }

    public function addSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendMessage(NotificationType $message, array $params): void
    {
        $email = (new Email())
            ->from($this->sender)
            ->to(...$this->receivers)
            ->subject($message->getSubject())
            ->html($this->messageBuilder->build($message, $params));

        $this->sendNotification($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendNotification($message): void
    {
        $this->mailer->send($message);
    }

    public function isSupported(string $type): bool
    {
        if ('email' === $type) {
            return true;
        }

        return false;
    }
}

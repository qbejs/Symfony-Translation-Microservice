<?php

namespace App\Infrastructure\Notifier\Adapters\Providers;

use App\Domain\Interface\Notification\NotificationProviderInterface;
use App\Domain\Models\NotificationType;
use App\Infrastructure\Helper\MessageBuilder;
use GuzzleHttp\Client;

class TelegramNotificationProvider implements NotificationProviderInterface
{
    private Client $httpClient;
    private ?string $chatId = null;
    private string $botToken;
    private string $sender = 'System';

    public function __construct(string $baseUri, string $botToken, private readonly MessageBuilder $messageBuilder)
    {
        $this->httpClient = new Client(['base_uri' => $baseUri]);
        $this->botToken = $botToken;
    }

    public function createClient(array $params = []): void
    {
        if (isset($params['chatId'])) {
            $this->chatId = $params['chatId'];
        }
    }

    public function addReceiver(string $receiver): void
    {
        $this->chatId = $receiver;
    }

    private function sendNotification(string $message): void
    {
        if (!$this->chatId) {
            throw new \RuntimeException('Chat ID is not set. Cannot send Telegram notification.');
        }

        $response = $this->httpClient->post("/bot{$this->botToken}/sendMessage", [
            'form_params' => [
                'chat_id' => $this->chatId,
                'text' => $message,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        if (!$data['ok']) {
            throw new \RuntimeException('Failed to send Telegram notification: '.$data['description']);
        }
    }

    public function isSupported(string $type): bool
    {
        return 'telegram' === $type;
    }

    public function addSender(string $sender): void
    {
        $this->sender = $sender;
    }

    public function sendMessage(NotificationType $message, array $params): void
    {
        $text = $this->messageBuilder->build($message, $params, true);
        $this->sendNotification($text);
    }
}

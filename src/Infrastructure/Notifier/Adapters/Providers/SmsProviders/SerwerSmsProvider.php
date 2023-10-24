<?php

namespace App\Infrastructure\Notifier\Adapters\Providers\SmsProviders;

use App\Domain\Interface\Notification\SmsProviderInterface;
use Psr\Log\LoggerInterface;
use SerwerSMS\SerwerSMS;
use SerwerSMS\SerwerSMS\Exception;

class SerwerSmsProvider implements SmsProviderInterface
{
    private SerwerSMS $provider;

    /**
     * @throws Exception
     */
    public function __construct(string $token, private readonly LoggerInterface $logger)
    {
        $this->provider = new SerwerSMS($token);
    }

    public function isSupported(string $type): bool
    {
        return 'serwersms' === $type;
    }

    public function send(string $receiver, string $message): bool
    {
        try {
            $result = $this->provider->messages->sendSms($receiver, $message);

            return $result->success;
        } catch (Exception $e) {
            $this->logger->error('Cannot send SMS: '.$e->getMessage());

            return false;
        }
    }
}

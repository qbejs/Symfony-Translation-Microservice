<?php

namespace App\Infrastructure\Notifier\Adapters\Providers\SmsProviders;

use App\Domain\Interface\Notification\SmsProviderInterface;
use Psr\Log\LoggerInterface;
use Smsapi\Client\Curl\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Service\SmsapiPlService;

class SmsApiProvider implements SmsProviderInterface
{
    private SmsapiPlService $client;
    private string $token;

    public function __construct(string $token, private readonly LoggerInterface $logger)
    {
        $this->token = $token;
        $api = new SmsapiHttpClient();
        $this->client = $api->smsapiPlService($this->token);
    }

    public function isSupported(string $type): bool
    {
        return 'smsapi' === $type;
    }

    public function send(string $receiver, string $message): bool
    {
        try {
            $sms = SendSmsBag::withMessage($receiver, $message);

            $this->client->smsFeature()->sendSms($sms);

            return true;
        } catch (\Exception $e) {
            $this->logger->error('Cannot send SMS: '.$e->getMessage());

            return false;
        }
    }
}

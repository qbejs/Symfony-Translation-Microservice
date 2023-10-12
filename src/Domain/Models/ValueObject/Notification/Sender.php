<?php

namespace App\Domain\Models\ValueObject\Notification;

class Sender
{
    private string $sender;

    public function __construct(string $sender)
    {
        $this->sender = $sender;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

}
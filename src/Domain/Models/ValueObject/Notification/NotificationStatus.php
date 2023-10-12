<?php

namespace App\Domain\Models\ValueObject\Notification;

use App\Domain\Models\ValueObject\Notification\Enum\NotificationStatusEnum;

class NotificationStatus
{
    private string $status;

    public function __construct(string $status)
    {
        if (empty($status)) {
            throw new \InvalidArgumentException('Notification status cannot be empty');
        }

        if (NotificationStatusEnum::tryFrom($status) === null) {
            throw new \InvalidArgumentException('Invalid notification status');
        }

        $this->status = $status;
    }

    public function getValue(): string
    {
        return $this->status;
    }
}
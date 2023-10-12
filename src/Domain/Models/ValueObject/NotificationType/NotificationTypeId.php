<?php

namespace App\Domain\Models\ValueObject\NotificationType;

class NotificationTypeId
{
    private int $id;

    public function __construct(int $id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Notification id cannot be empty');
        }

        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }
}
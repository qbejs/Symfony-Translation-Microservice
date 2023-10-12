<?php

namespace App\Domain\Models\ValueObject\NotificationType;

class NotificationTypeSubject
{
    private string $subject;

    public function __construct(string $subject)
    {
        if (empty($subject)) {
            throw new \InvalidArgumentException('Notification subject cannot be empty');
        }

        $this->subject = $subject;
    }

    public function getValue(): string
    {
        return $this->subject;
    }
}
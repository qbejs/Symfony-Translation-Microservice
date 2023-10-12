<?php

namespace App\Domain\Models\ValueObject\NotificationType;

class NotificationTypeContent
{
    private string $content;

    public function __construct(string $content)
    {
        if (empty($content)) {
            throw new \InvalidArgumentException('Notification content cannot be empty');
        }

        $this->content = $content;
    }

    public function getValue(): string
    {
        return $this->content;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
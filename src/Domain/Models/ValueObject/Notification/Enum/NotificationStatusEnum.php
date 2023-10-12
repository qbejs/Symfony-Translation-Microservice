<?php

namespace App\Domain\Models\ValueObject\Notification\Enum;

enum NotificationStatusEnum: string
{
    case PENDING = 'pending';
    case SENT = 'sent';
    case FAILED = 'failed';
}

<?php

namespace App\Infrastructure\Notifier;

enum SupportedNotificationTypesEnum: string
{
    case EMAIL = 'email';
    case SMS = 'sms';
    case TELEGRAM = 'telegram';
}

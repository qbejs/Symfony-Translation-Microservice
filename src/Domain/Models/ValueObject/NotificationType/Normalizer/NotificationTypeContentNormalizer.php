<?php

namespace App\Domain\Models\ValueObject\NotificationType\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeContent;

class NotificationTypeContentNormalizer extends AbstractValueObjectNormalizer
{
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof NotificationTypeContent;
    }
}

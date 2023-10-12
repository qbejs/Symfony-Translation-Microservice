<?php

namespace App\Domain\Models\ValueObject\NotificationType\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeName;

class NotificationTypeNameNormalizer extends AbstractValueObjectNormalizer
{
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof NotificationTypeName;
    }
}
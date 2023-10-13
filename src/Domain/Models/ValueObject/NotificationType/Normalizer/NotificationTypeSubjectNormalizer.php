<?php

namespace App\Domain\Models\ValueObject\NotificationType\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\NotificationType\NotificationTypeSubject;

class NotificationTypeSubjectNormalizer extends AbstractValueObjectNormalizer
{
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof NotificationTypeSubject;
    }
}

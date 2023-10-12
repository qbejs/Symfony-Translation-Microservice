<?php

namespace App\Domain\Models\ValueObject\Notification\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\Notification\NotificationId;

class NotificationIdNormalizer extends AbstractValueObjectNormalizer
{

    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof NotificationId;
    }
}
<?php

namespace App\Domain\Models\ValueObject\Notification\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\Notification\Sender;

class SenderNormalizer extends AbstractValueObjectNormalizer
{
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Sender;
    }
}

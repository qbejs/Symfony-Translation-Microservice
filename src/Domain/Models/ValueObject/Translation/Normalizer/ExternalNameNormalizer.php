<?php

namespace App\Domain\Models\ValueObject\Translation\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\Translation\ExternalName;

class ExternalNameNormalizer extends AbstractValueObjectNormalizer
{
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof ExternalName;
    }
}

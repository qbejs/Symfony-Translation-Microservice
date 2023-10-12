<?php

namespace App\Domain\Models\ValueObject\Translation\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\Translation\ExternalId;
use App\Domain\Models\ValueObject\Translation\SourceText;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExternalIdNormalizer extends AbstractValueObjectNormalizer
{
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof ExternalId;
    }
}
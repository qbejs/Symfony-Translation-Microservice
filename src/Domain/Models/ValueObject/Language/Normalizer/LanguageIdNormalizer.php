<?php

namespace App\Domain\Models\ValueObject\Language\Normalizer;

use App\Domain\Models\Normalizer\AbstractValueObjectNormalizer;
use App\Domain\Models\ValueObject\Language\LanguageId;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LanguageIdNormalizer extends AbstractValueObjectNormalizer
{
    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof LanguageId;
    }
}
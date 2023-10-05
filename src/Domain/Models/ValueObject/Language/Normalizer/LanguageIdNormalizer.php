<?php

namespace App\Domain\Models\ValueObject\Language\Normalizer;

use App\Domain\Models\ValueObject\Language\LanguageId;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LanguageIdNormalizer implements NormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function normalize(mixed $object, string $format = null, array $context = []): int
    {
        return $object->getValue();
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof LanguageId;
    }
}
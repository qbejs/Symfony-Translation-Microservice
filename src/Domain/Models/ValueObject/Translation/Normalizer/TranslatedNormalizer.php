<?php

namespace App\Domain\Models\ValueObject\Translation\Normalizer;

use App\Domain\Models\ValueObject\Translation\Translated;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslatedNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        /** @var Translated $object */
        return $object->getValue();
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Translated;
    }
}
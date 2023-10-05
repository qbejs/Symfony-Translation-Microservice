<?php

namespace App\Domain\Models\ValueObject\Translation\Normalizer;

use App\Domain\Models\ValueObject\Translation\SourceText;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class SourceTextNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return $object->getValue();
    }

    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof SourceText;
    }
}
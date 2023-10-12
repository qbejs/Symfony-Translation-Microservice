<?php

namespace App\Domain\Models\Normalizer;

use App\Domain\Models\Language;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LanguageNormalizer implements NormalizerInterface
{

    /**
     * @inheritDoc
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId()->getValue(),
            'name' => $object->getName()->getValue(),
            'code' => $object->getCode()->getValue(),
            'availability' => $object->getAvailability()->getValue(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Language;
    }
}
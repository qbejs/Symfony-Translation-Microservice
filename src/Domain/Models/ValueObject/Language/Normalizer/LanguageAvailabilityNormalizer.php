<?php

namespace App\Domain\Models\ValueObject\Language\Normalizer;

use App\Domain\Models\ValueObject\Language\LanguageAvailability;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LanguageAvailabilityNormalizer implements NormalizerInterface
{

    /**
     * @var LanguageAvailability $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        return [
            'public' => $object->isAvailableInPublic(),
            'microservice' => $object->isAvailableInMicroservice()
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof LanguageAvailability;
    }
}
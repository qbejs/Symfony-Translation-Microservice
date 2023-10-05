<?php

namespace App\Domain\Models\ValueObject\Translation\Normalizer;

use App\Domain\Models\ValueObject\Translation\TranslationId;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslationIdNormalizer implements NormalizerInterface
{

        /**
        * @inheritDoc
        */
        public function normalize(mixed $object, string $format = null, array $context = []): string
        {
            return $object->getValue();
        }

        /**
        * @inheritDoc
        */
        public function supportsNormalization(mixed $data, string $format = null): bool
        {
            return $data instanceof TranslationId;
        }
}
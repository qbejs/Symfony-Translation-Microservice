<?php

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\Models\ValueObject\Language\LanguageAvailability;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class LanguageAvailabilityType extends Type
{
    const LANGUAGE_AVAILABILITY = 'language_availability';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return "JSON";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?LanguageAvailability
    {
        $data = json_decode($value, true);

        if (is_array($data) && isset($data['publicMicroservice']) && isset($data['microservice'])) {
            return new LanguageAvailability($data['publicMicroservice'], $data['microservice']);
        }

        return new LanguageAvailability(false, false);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof LanguageAvailability) {
            return json_encode([
                'publicMicroservice' => $value->isAvailableInPublic(),
                'microservice' => $value->isAvailableInMicroservice()
            ]);
        }

        return null;
    }

    public function getName(): string
    {
        return self::LANGUAGE_AVAILABILITY;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}

<?php

namespace App\Domain\Factory;

use App\Application\Language\DTO\LanguageDTO;
use App\Domain\Factory\Interface\LanguageFactoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\ValueObject\Language\LanguageAvailability;
use App\Domain\Models\ValueObject\Language\LanguageCode;
use App\Domain\Models\ValueObject\Language\LanguageName;

class LanguageFactory implements LanguageFactoryInterface
{
    /**
     *
     * @param LanguageDTO $dto
     * @return Language
     */
    public function createFromDTO(LanguageDTO $dto): Language
    {
        $name = new LanguageName($dto->name);
        $code = new LanguageCode($dto->code);
        $availability = new LanguageAvailability($dto->public, $dto->microservice);

        return new Language(null, $name, $code, $availability);
    }

    /**
     *
     * @param string|null $name
     * @param string|null $code
     * @param LanguageAvailability|null $availability
     * @return Language
     */
    public function create(string $name = null, string $code = null, LanguageAvailability $availability = null): Language
    {
        return new Language(null, new LanguageName($name), new LanguageCode($code), $availability);
    }
}

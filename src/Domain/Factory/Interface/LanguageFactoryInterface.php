<?php

namespace App\Domain\Factory\Interface;

use App\Application\Language\DTO\LanguageDTO;
use App\Domain\Models\Language;
use App\Domain\Models\ValueObject\Language\LanguageAvailability;

interface LanguageFactoryInterface
{
    public function create(
        string $name = null,
        string $code = null,
        LanguageAvailability $availability = null
    ): Language;

    public function createFromDTO(LanguageDTO $dto): Language;
}

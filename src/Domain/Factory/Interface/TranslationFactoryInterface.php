<?php

namespace App\Domain\Factory\Interface;

use App\Application\Translator\DTO\TranslationDTO;
use App\Domain\Models\Translation;

interface TranslationFactoryInterface
{
    public function createFromDTO(
        TranslationDTO $dto
    ): Translation;

    public function create(
        int $source,
        ?string $translated,
        int $id = null,
        \DateTime $createdAt = null,
        \DateTime $updatedAt = null,
        \DateTime $deletedAt = null
    ): Translation;
}

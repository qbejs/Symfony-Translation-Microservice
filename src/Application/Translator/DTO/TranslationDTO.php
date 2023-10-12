<?php

namespace App\Application\Translator\DTO;

use Prugala\RequestDto\Dto\RequestDtoInterface;

class TranslationDTO implements RequestDtoInterface
{
    public ?int $id = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
    public ?string $translated = null;
    public int $source;
    public int $languageId;
    public string $text;
    public ?int $externalId = null;
    public ?string $externalName = null;
}
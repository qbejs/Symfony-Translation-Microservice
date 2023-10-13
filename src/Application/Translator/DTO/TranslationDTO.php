<?php

namespace App\Application\Translator\DTO;

use Prugala\RequestDto\Dto\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TranslationDTO implements RequestDtoInterface
{
    #[Assert\Positive]
    public ?int $id = null;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
    public ?string $translated = null;
    #[Assert\Positive]
    public int $source;
    #[Assert\Positive]
    public int $languageId;
    #[Assert\NotBlank]
    public string $text;
    #[Assert\Positive]
    public ?int $externalId = null;
    public ?string $externalName = null;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'deletedAt' => $this->deletedAt,
            'translated' => $this->translated,
            'source' => $this->source,
            'languageId' => $this->languageId,
            'text' => $this->text,
            'externalId' => $this->externalId,
            'externalName' => $this->externalName,
        ];
    }
}

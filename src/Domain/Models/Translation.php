<?php

namespace App\Domain\Models;

use App\Domain\Interface\TimestampInterface;
use App\Domain\Models\ValueObject\Translation\ExternalId;
use App\Domain\Models\ValueObject\Translation\ExternalName;
use App\Domain\Models\ValueObject\Translation\SourceText;
use App\Domain\Models\ValueObject\Translation\Translated;
use App\Domain\Models\ValueObject\Translation\TranslationId;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

class Translation implements TimestampInterface
{
    #[Groups(['translation'])]
    private TranslationId $id;
    #[Groups(['translation'])]
    private \DateTimeInterface $createdAt;
    #[Groups(['translation'])]
    private \DateTimeInterface $updatedAt;
    #[Groups(['translation'])]
    private ?\DateTimeInterface $deletedAt;
    #[Groups(['translation'])]
    private Language $source;

    #[Groups(['translation'])]
    private SourceText $sourceText;
    #[Groups(['translation'])]
    private ?Translated $translated;
    #[Groups(['translation'])]
    private ?Language $language;
    #[Groups(['translation'])]
    private ?ExternalId $externalId;
    #[Groups(['translation'])]
    private ?ExternalName $externalName;

    public function __construct(SourceText $sourceText, Language $source, ?Translated $translated, ?Language $language, ?ExternalId $externalId, ?ExternalName $externalName)
    {
        $this->sourceText = $sourceText;
        $this->source = $source;
        $this->translated = $translated;
        $this->language = $language;
        $this->externalId = $externalId;
        $this->externalName = $externalName;
    }

    public function getExternalId(): ?ExternalId
    {
        return $this->externalId;
    }

    public function setExternalId(?ExternalId $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getExternalName(): ?ExternalName
    {
        return $this->externalName;
    }

    public function setExternalName(?ExternalName $externalName): void
    {
        $this->externalName = $externalName;
    }

    public function getSourceText(): SourceText
    {
        return $this->sourceText;
    }

    public function setSourceText(SourceText $sourceText): void
    {
        $this->sourceText = $sourceText;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): void
    {
        $this->language = $language;
    }

    public function getId(): TranslationId
    {
        return $this->id;
    }

    public function setId(TranslationId $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getSource(): Language
    {
        return $this->source;
    }

    public function setSource(Language $source): void
    {
        $this->source = $source;
    }

    public function getTranslated(): ?Translated
    {
        return $this->translated;
    }

    public function setTranslated(?Translated $translated): void
    {
        $this->translated = $translated;
    }

}
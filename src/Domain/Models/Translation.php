<?php

namespace App\Domain\Models;

use App\Domain\Interface\UpdatedAtInterface;
use App\Domain\Models\ValueObject\Translation\SourceText;
use App\Domain\Models\ValueObject\Translation\Translated;
use App\Domain\Models\ValueObject\Translation\TranslationId;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

class Translation implements UpdatedAtInterface
{
    #[Groups(['translation'])]
    private TranslationId $id;
    #[Groups(['translation'])]
    private \DateTime $createdAt;
    #[Groups(['translation'])]
    private \DateTime $updatedAt;
    #[Groups(['translation'])]
    private ?\DateTime $deletedAt;
    #[Groups(['translation'])]
    private Language $source;

    #[Groups(['translation'])]
    private SourceText $sourceText;
    #[Groups(['translation'])]
    private ?Translated $translated;
    #[Groups(['translation'])]
    private ?Language $language;

    public function __construct(SourceText $sourceText, Language $source, ?Translated $translated, ?Language $language)
    {
        $this->sourceText = $sourceText;
        $this->source = $source;
        $this->translated = $translated;
        $this->language = $language;
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

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?\DateTime
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
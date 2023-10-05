<?php

namespace App\Domain\Models;

use App\Domain\Models\ValueObject\Language\LanguageAvailability;
use App\Domain\Models\ValueObject\Language\LanguageCode;
use App\Domain\Models\ValueObject\Language\LanguageId;
use App\Domain\Models\ValueObject\Language\LanguageName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\MaxDepth;

class Language
{
    private ?LanguageId $id;
    private LanguageName $name;
    private LanguageCode $code;

    private LanguageAvailability $availability;
    private Collection $translations;
    private Collection $translationsSource;

    public function __construct(?LanguageId $languageId, ?LanguageName $name, ?LanguageCode $code, ?LanguageAvailability $availability)
    {
        $this->id = $languageId;
        $this->name = $name;
        $this->code = $code;
        $this->availability = $availability;
        $this->translations = new ArrayCollection();
        $this->translationsSource = new ArrayCollection();
    }

    public function getId(): ?LanguageId
    {
        return $this->id;
    }

    public function setId(LanguageId $id): void
    {
        $this->id = $id;
    }

    public function getName(): LanguageName
    {
        return $this->name;
    }

    public function getCode(): LanguageCode
    {
        return $this->code;
    }

    public function addTranslation(Translation $translation): void
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setLanguage($this);
        }
    }

    public function removeTranslation(Translation $translation): void
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
            $translation->setLanguage(null);
        }
    }

    /**
     * @return Translation[]
     */
    public function getTranslations(): array
    {
        return $this->translations->toArray();
    }

    public function addTranslationSource(Translation $translation): void
    {
        if (!$this->translationsSource->contains($translation)) {
            $this->translationsSource->add($translation);
            $translation->setSource($this);
        }
    }

    /**
     * @return Translation[]
     */
    public function getTranslationsSource(): array
    {
        return $this->translationsSource->toArray();
    }

    public function setName(LanguageName $name): void
    {
        $this->name = $name;
    }

    public function setCode(LanguageCode $code): void
    {
        $this->code = $code;
    }

    public function setAvailability(LanguageAvailability $availability): void
    {
        $this->availability = $availability;
    }

    public function getAvailability(): LanguageAvailability
    {
        return $this->availability;
    }
}
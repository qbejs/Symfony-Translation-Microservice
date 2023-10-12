<?php

namespace App\Domain\Factory;

use App\Application\Translator\DTO\TranslationDTO;
use App\Domain\Factory\Interface\TranslationFactoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\Translation;
use App\Domain\Models\ValueObject\Language\LanguageId;
use App\Domain\Models\ValueObject\Translation\ExternalId;
use App\Domain\Models\ValueObject\Translation\ExternalName;
use App\Domain\Models\ValueObject\Translation\SourceText;
use App\Domain\Models\ValueObject\Translation\Translated;
use App\Domain\Models\ValueObject\Translation\TranslationId;

class TranslationFactory implements TranslationFactoryInterface
{
    /**
     * Create Translation from DTO
     * @throws \Exception
     */
    public function createFromDTO(TranslationDTO $dto, ?Language $sourceLanguage = null, ?Language $targetLanguage = null): Translation
    {

        $translation = new Translation(
            new SourceText($dto->text),
            $sourceLanguage,
            $dto->translated ? new Translated($dto->translated) : null,
            $targetLanguage,
            $dto->externalId,
            $dto->externalName
        );

        if ($dto->createdAt) {
            $translation->setCreatedAt(new \DateTime($dto->createdAt));
        }

        if ($dto->updatedAt) {
            $translation->setUpdatedAt(new \DateTime($dto->updatedAt));
        }

        if ($dto->deletedAt) {
            $translation->setDeletedAt($dto->deletedAt);
        }

        return $translation;
    }

    /**
     * Create Translation from primitives
     */
    public function create(
        int $source,
        ?string $translated,
        ?int $id = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null,
        ?\DateTime $deletedAt = null,
        ?string $externalId = null,
        ?string $externalName = null,
    ): Translation {
        return new Translation(
            new SourceText($source),
            $source ? new Language(new LanguageId($source), null, null, null) : null,
            $translated ? new Translated($translated) : null,
            $id ? new Language(new LanguageId($id), null, null, null, null) : null,
            $externalId ? new ExternalId($externalId) : null,
            $externalName ? new ExternalName($externalName) : null,
        );
    }
}

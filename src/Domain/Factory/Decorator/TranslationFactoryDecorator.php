<?php

namespace App\Domain\Factory\Decorator;

use App\Application\Translator\DTO\TranslationDTO;
use App\Domain\Factory\Interface\TranslationFactoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\Translation;
use App\Domain\Models\ValueObject\Translation\TranslationId;
use App\Infrastructure\Doctrine\Repository\LanguageRepository;
use App\Infrastructure\Doctrine\Repository\TranslationRepository;
use Psr\Log\LoggerInterface;

class TranslationFactoryDecorator implements TranslationFactoryInterface
{
    private TranslationFactoryInterface $innerFactory;
    private LanguageRepository $languageRepository;
    private TranslationRepository $translationRepository;

    public function __construct(TranslationFactoryInterface $innerFactory, LanguageRepository $languageRepository, TranslationRepository $translationRepository)
    {
        $this->innerFactory = $innerFactory;
        $this->languageRepository = $languageRepository;
        $this->translationRepository = $translationRepository;
    }

    /**
     * @throws \Exception
     */
    public function createFromDTO(TranslationDTO $dto): Translation
    {
        $sourceLanguage = $this->getSourceLanguageFromDTO($dto);
        $targetLanguage = $this->getTargetLanguageFromDTO($dto);
        $translation = $this->innerFactory->createFromDTO($dto, $sourceLanguage, $targetLanguage);

        if ($dto->id) {
            $object = $this->translationRepository->find($dto->id);

            if (empty($object)) {
                $translation->setId(new TranslationId($dto->id));
            } else {
                return $object;
            }
        }

        $translation->setCreatedAt(new \DateTime());


        if ($dto->languageId) {
            $language = $this->languageRepository->find($dto->languageId);
            if ($language) {
                $translation->setLanguage($language);
            } else {
                throw new \Exception('Desired language not found');
            }
        }

        if ($dto->source) {
            $languageSource = $this->languageRepository->find($dto->source);
            if ($languageSource) {
                $translation->setSource($languageSource);
            } else {
                throw new \Exception('Source language not found');
            }
        }
        return $translation;
    }

    public function create(
        int $source,
        ?string $translated,
        ?int $id = null,
        ?\DateTime $createdAt = null,
        ?\DateTime $updatedAt = null,
        ?\DateTime $deletedAt = null
    ): Translation {
        return $this->innerFactory->create($source, $translated, $id, $createdAt, $updatedAt, $deletedAt);
    }

    private function getSourceLanguageFromDTO(TranslationDTO $dto): ?Language
    {
        if ($dto->source) {
            $sourceLanguage = $this->languageRepository->find($dto->source);
            if (!$sourceLanguage) {
                throw new \Exception('Source language not found');
            }
            return $sourceLanguage;
        }
        return null;
    }

    private function getTargetLanguageFromDTO(TranslationDTO $dto): ?Language
    {
        if ($dto->languageId) {
            $targetLanguage = $this->languageRepository->find($dto->languageId);
            if (!$targetLanguage) {
                throw new \Exception('Desired language not found');
            }
            return $targetLanguage;
        }
        return null;
    }

}

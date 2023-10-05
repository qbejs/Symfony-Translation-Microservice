<?php

namespace App\Domain\Factory\Decorator;

use App\Application\Language\DTO\LanguageDTO;
use App\Domain\Factory\Interface\LanguageFactoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\ValueObject\Language\LanguageAvailability;
use App\Infrastructure\Doctrine\Repository\LanguageRepository;

class LanguageFactoryDecorator implements LanguageFactoryInterface
{
    private LanguageFactoryInterface $innerFactory;
    private LanguageRepository $languageRepository;

    public function __construct(LanguageFactoryInterface $innerFactory, LanguageRepository $languageRepository)
    {
        $this->innerFactory = $innerFactory;
        $this->languageRepository = $languageRepository;
    }

    public function createFromDTO(LanguageDTO $dto): Language
    {
        $translation = $this->innerFactory->createFromDTO($dto);

        if ($dto->id) {
            $object = $this->languageRepository->find($dto->id);

            if (!empty($object)) {
                return $object;
            }
        }

        return $translation;
    }

    public function create(
        ?string $name = null,
        ?string $code = null,
        ?LanguageAvailability $availability = null
    ): Language {
        return $this->innerFactory->create($name, $code, $availability);
    }
}

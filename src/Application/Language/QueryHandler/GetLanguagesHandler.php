<?php

namespace App\Application\Language\QueryHandler;

use App\Application\Language\Query\GetLanguagesQuery;
use App\Domain\Interface\LanguageRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetLanguagesHandler
{
    public function __construct(private readonly LanguageRepositoryInterface $languageRepository) {}

    public function __invoke(GetLanguagesQuery $query)
    {
        return $this->languageRepository->findAll();
    }
}
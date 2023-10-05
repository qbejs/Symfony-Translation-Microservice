<?php

namespace App\Application\Language\QueryHandler;

use App\Application\Language\Query\GetLanguageByIdQuery;
use App\Domain\Interface\LanguageRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetLanguageByIdHandler
{
    public function __construct(private readonly LanguageRepositoryInterface $languageRepository) {}

    public function __invoke(GetLanguageByIdQuery $query)
    {
        return $this->languageRepository->find($query->getLanguageId());
    }
}
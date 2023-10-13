<?php

namespace App\Application\Translator\QueryHandler;

use App\Application\Translator\Query\GetTranslationsQuery;
use App\Domain\Interface\TranslationRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetTranslationsHandler
{
    public function __construct(private readonly TranslationRepositoryInterface $translationRepository)
    {
    }

    public function __invoke(GetTranslationsQuery $query)
    {
        return $this->translationRepository->findAll();
    }
}

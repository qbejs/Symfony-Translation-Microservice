<?php

namespace App\Application\Translator\QueryHandler;

use App\Application\Translator\Query\GetTranslationByIdQuery;
use App\Domain\Interface\TranslationRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetTranslationByIdHandler
{
    public function __construct(private readonly TranslationRepositoryInterface $translationRepository)
    {
    }

    public function __invoke(GetTranslationByIdQuery $query)
    {
        return $this->translationRepository->find($query->getId());
    }
}

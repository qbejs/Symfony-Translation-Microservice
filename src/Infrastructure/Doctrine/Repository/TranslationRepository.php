<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Interface\TranslationRepositoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\Translation;
use Doctrine\ORM\EntityManagerInterface;

class TranslationRepository implements TranslationRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id): ?Translation
    {
        return $this->entityManager->getRepository(Translation::class)->find($id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Translation::class)->findAll();
    }

    public function save(Translation $language): void
    {
        $this->entityManager->persist($language);
        $this->entityManager->flush();
    }

    public function delete(Translation $language): void
    {
        $this->entityManager->remove($language);
        $this->entityManager->flush();
    }
}
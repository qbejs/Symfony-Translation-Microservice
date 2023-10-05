<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Models\Language;
use Doctrine\ORM\EntityManagerInterface;

class LanguageRepository implements LanguageRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id): ?Language
    {
        return $this->entityManager->getRepository(Language::class)->find($id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Language::class)->findAll();
    }

    public function save(Language $language): void
    {
        $this->entityManager->persist($language);
        $this->entityManager->flush();
    }

    public function delete(Language $language): void
    {
        $this->entityManager->remove($language);
        $this->entityManager->flush();
    }
}
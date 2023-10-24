<?php

namespace App\Infrastructure\Repository\Doctrine;

use App\Domain\Interface\NotificationTypeRepositoryInterface;
use App\Domain\Models\NotificationType;
use Doctrine\ORM\EntityManagerInterface;

class NotificationTypeRepository implements NotificationTypeRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id): ?NotificationType
    {
        return $this->entityManager->getRepository(NotificationType::class)->find($id);
    }

    public function findByName(string $name): ?NotificationType
    {
        return $this->entityManager->getRepository(NotificationType::class)->findOneBy(['name' => $name]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(NotificationType::class)->findAll();
    }

    public function save(NotificationType $notificationType): void
    {
        $this->entityManager->persist($notificationType);
        $this->entityManager->flush();
    }

    public function delete(NotificationType $notificationType): void
    {
        $this->entityManager->remove($notificationType);
        $this->entityManager->flush();
    }
}

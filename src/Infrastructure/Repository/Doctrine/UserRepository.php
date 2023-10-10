<?php

namespace App\Infrastructure\Repository\Doctrine;

use App\Domain\Interface\UserRepositoryInterface;
use App\Domain\Models\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function find($id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByEmail($email): ?User
    {
        return $this->entityManager->createQueryBuilder('u')
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
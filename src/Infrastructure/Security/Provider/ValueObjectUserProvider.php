<?php

namespace App\Infrastructure\Security\Provider;

use App\Domain\Interface\UserRepositoryInterface;
use App\Domain\Models\User;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ValueObjectUserProvider implements UserProviderInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException();
        }

        return $this->userRepository->find($user->getId()->getValue());
    }

    public function supportsClass(string $class)
    {
        return User::class === $class;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // Znajdź użytkownika na podstawie e-maila przy użyciu Value Object
        $user = $this->userRepository->findOneByEmail($identifier);

        if (!$user) {
            throw new \Exception('User not found');
        }

        return $user;
    }
}

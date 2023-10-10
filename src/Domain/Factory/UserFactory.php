<?php

namespace App\Domain\Factory;

use App\Application\User\DTO\UserDTO;
use App\Domain\Factory\Interface\UserFactoryInterface;
use App\Domain\Models\User;
use App\Domain\Models\ValueObject\User\Email;
use App\Domain\Models\ValueObject\User\Password;
use App\Domain\Models\ValueObject\User\Roles;
use App\Domain\Models\ValueObject\User\Username;

class UserFactory implements UserFactoryInterface
{

    public function createFromDTO(UserDTO $dto): User
    {
        return new User(
            null,
            new Username($dto->username),
            new Password($dto->password),
            new Email($dto->email),
            new Roles(['ROLE_USER']),
            new \DateTime(),
            new \DateTime(),
            null
        );
    }

    public function create(string $username, string $email, ?string $password): User
    {
        return new User(
            null,
            new Username($username),
            null === $password ? null : new Password($password),
            new Email($email),
            new Roles(['ROLE_USER']),
            new \DateTime(),
            new \DateTime(),
            null
        );
    }
}
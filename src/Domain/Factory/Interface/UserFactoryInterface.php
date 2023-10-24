<?php

namespace App\Domain\Factory\Interface;

use App\Domain\Models\DTO\UserDTO;
use App\Domain\Models\User;

interface UserFactoryInterface
{
    public function createFromDTO(
        UserDTO $dto
    ): User;

    public function create(
        string $username,
        string $email,
        string $password,
    ): User;
}

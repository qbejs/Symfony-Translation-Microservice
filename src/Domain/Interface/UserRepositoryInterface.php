<?php

namespace App\Domain\Interface;

use App\Domain\Models\User;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;

    public function findAll(): array;

    public function save(User $user): void;

    public function delete(User $user): void;
}

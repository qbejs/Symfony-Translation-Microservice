<?php

namespace App\Domain\Factory\Interface;

use App\Application\Translator\DTO\TranslationDTO;
use App\Application\User\DTO\UserDTO;
use App\Domain\Models\Translation;
use App\Domain\Models\User;

interface UserFactoryInterface {
    public function createFromDTO(
        UserDTO $dto
    ): User;

    public function create(
        string $username,
        string $email,
        string $password,
    ): User;
}
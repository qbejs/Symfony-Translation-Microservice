<?php

namespace App\Application\User\DTO;

use Prugala\RequestDto\Dto\RequestDtoInterface;

class UserDTO implements RequestDtoInterface
{
    public string $username;
    public string $email;
    public string $password;

    public function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'email'    => $this->email,
            'password' => $this->password,
        ];
    }

}
<?php

namespace App\Domain\Models\ValueObject\User;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
//        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
//            throw new \InvalidArgumentException("Invalid email format.");
//        }

        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
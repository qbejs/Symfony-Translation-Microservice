<?php

namespace App\Domain\Models\ValueObject\User;

class Username
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException("Username cannot be empty.");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
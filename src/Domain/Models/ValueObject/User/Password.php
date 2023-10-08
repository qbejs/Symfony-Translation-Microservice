<?php

namespace App\Domain\Models\ValueObject\User;

class Password
{
    private string $value;

    public function __construct(string $value)
    {
        if (strlen($value) < 8) {
            throw new \InvalidArgumentException("Password must have at least 8 characters.");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
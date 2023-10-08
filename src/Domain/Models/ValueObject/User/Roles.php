<?php

namespace App\Domain\Models\ValueObject\User;

class Roles
{
    private array $values;

    public function __construct(array $values)
    {
        if (empty($values)) {
            throw new \InvalidArgumentException("User must have at least one role.");
        }

        foreach ($values as $value) {
            if (!is_string($value)) {
                throw new \InvalidArgumentException("Each role must be a string.");
            }
        }

        $this->values = $values;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->values, true);
    }
}
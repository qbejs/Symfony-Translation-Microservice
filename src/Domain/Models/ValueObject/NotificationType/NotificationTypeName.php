<?php

namespace App\Domain\Models\ValueObject\NotificationType;

class NotificationTypeName
{
    private string $name;

    public function __construct(string $name)
    {
        $this->validateName($name);
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }

    private function validateName(string $name): void
    {
        if (!preg_match('/^[a-z_]+$/', $name)) {
            throw new \InvalidArgumentException('Invalid name format. Name should contain only lowercase letters and underscores.');
        }

        if (str_contains($name, ' ')) {
            throw new \InvalidArgumentException('Name should not contain spaces. Use underscores instead.');
        }
    }
}

<?php

namespace App\Domain\Models\ValueObject\Language;

class LanguageName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Language name cannot be empty');
        }

        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }

    public function withName(string $name): self
    {
        return new self($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
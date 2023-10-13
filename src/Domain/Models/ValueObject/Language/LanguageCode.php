<?php

namespace App\Domain\Models\ValueObject\Language;

class LanguageCode
{
    private string $code;

    public function __construct(string $code)
    {
        if (empty($code)) {
            throw new \InvalidArgumentException('Language code cannot be empty');
        }

        $this->code = $code;
    }

    public function getValue(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}

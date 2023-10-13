<?php

namespace App\Domain\Models\ValueObject\Language;

class LanguageId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }
}

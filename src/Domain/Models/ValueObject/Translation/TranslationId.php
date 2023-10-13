<?php

namespace App\Domain\Models\ValueObject\Translation;

class TranslationId
{
    private int $id;

    public function __construct(int $id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('Id cannot be empty');
        }

        $this->id = $id;
    }

    public function getValue(): string
    {
        return $this->id;
    }
}

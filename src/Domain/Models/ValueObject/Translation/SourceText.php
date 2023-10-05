<?php

namespace App\Domain\Models\ValueObject\Translation;

class SourceText
{
    private string $sourceText;

    public function __construct(string $sourceText)
    {
        if (empty($sourceText)) {
            throw new \InvalidArgumentException('Source text cannot be empty');
        }

        $this->sourceText = $sourceText;
    }

    public function getValue(): string
    {
        return $this->sourceText;
    }

    public function withSource(string $sourceText): self
    {
        return new self($sourceText);
    }
}
<?php

namespace App\Domain\Models\ValueObject\Translation;

use Symfony\Component\Serializer\Annotation\Groups;

class Translated
{
    #[Groups(['translation'])]
    private string $translated;

    public function __construct(string $translated)
    {
        $this->translated = $translated;
    }

    public function getValue(): string
    {
        return $this->translated;
    }
}

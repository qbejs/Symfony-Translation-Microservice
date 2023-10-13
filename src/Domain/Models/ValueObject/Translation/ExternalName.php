<?php

namespace App\Domain\Models\ValueObject\Translation;

use Symfony\Component\Serializer\Annotation\Groups;

class ExternalName
{
    #[Groups(['translation'])]
    private ?string $externalName;

    public function __construct(?string $externalName)
    {
        $this->externalName = $externalName;
    }

    public function getValue(): ?string
    {
        return $this->externalName;
    }
}

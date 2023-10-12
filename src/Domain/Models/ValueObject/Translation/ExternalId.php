<?php

namespace App\Domain\Models\ValueObject\Translation;

use Symfony\Component\Serializer\Annotation\Groups;

class ExternalId
{
    #[Groups(['translation'])]
    private ?int $externalId;

    public function __construct(?int $externalId)
    {
        $this->externalId = $externalId;
    }

    public function getValue(): ?int
    {
        return $this->externalId;
    }
}

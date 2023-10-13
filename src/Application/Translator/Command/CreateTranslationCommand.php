<?php

namespace App\Application\Translator\Command;

class CreateTranslationCommand
{
    public string $source;
    public string $target;
    public string $text;
    public ?int $externalId;
    public ?string $externalName;

    public function __construct(string $source, string $target, string $text, ?int $externalId, ?string $externalName)
    {
        $this->source = $source;
        $this->target = $target;
        $this->text = $text;
        $this->externalId = $externalId;
        $this->externalName = $externalName;
    }
}

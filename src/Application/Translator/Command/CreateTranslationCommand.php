<?php

namespace App\Application\Translator\Command;

class CreateTranslationCommand
{
    public string $source;
    public string $target;
    public string $text;

    public function __construct(string $source, string $target, string $text)
    {
        $this->source = $source;
        $this->target = $target;
        $this->text = $text;
    }
}
<?php

namespace App\Domain\Interface\Translator;

interface TranslatorInterface
{
    public function translate(string $source, string $target, string $text): string;

    public function isSupported(string $name): bool;

    public function getName(): string;
}

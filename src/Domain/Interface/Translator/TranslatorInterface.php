<?php

namespace App\Domain\Interface\Translator;

interface TranslatorInterface
{
    public function translate(string $source, string $target, string $text): string;
    public function isSupported(): bool;

    public function getName(): string;

}
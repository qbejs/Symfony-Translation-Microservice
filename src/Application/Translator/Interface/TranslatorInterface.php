<?php

namespace App\Application\Translator\Interface;

interface TranslatorInterface
{
    public function translate(string $source, string $target, string $text): string;
    public function isSupported(): bool;

    public function getName(): string;

}
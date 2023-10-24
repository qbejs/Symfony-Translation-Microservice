<?php

namespace App\Infrastructure\TranslatorEngine\Engines;

use App\Domain\Interface\Translator\TranslatorInterface;

class GoogleTranslate implements TranslatorInterface
{
    public function translate(string $source, string $target, string $text): string
    {
        return 'Google Translate, please translate text - '.$text.' - from '.$source.' to '.$target;
    }

    public function isSupported(string $name): bool
    {
        return 'google' === $name;
    }

    public function getName(): string
    {
        $array = explode('\\', get_class($this));

        return end($array);
    }
}

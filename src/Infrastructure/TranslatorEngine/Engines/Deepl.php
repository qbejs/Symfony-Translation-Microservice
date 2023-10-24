<?php

namespace App\Infrastructure\TranslatorEngine\Engines;

use App\Domain\Interface\Translator\TranslatorInterface;

class Deepl implements TranslatorInterface
{
    public function translate(string $source, string $target, string $text): string
    {
        return 'DEEPL, please translate text - '.$text.' - from '.$source.' to '.$target;
    }

    public function isSupported(string $name): bool
    {
        return 'deepl' === $name;
    }

    public function getName(): string
    {
        $array = explode('\\', get_class($this));

        return end($array);
    }
}

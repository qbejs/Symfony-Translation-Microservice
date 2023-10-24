<?php

namespace App\Infrastructure\TranslatorEngine\Engines;

use App\Domain\Interface\Translator\TranslatorInterface;

class ChatGPT implements TranslatorInterface
{
    public function translate(string $source, string $target, string $text): string
    {
        return 'Hey, ChatGPT, please translate text - '.$text.' - from '.$source.' to '.$target;
    }

    public function isSupported(string $name): bool
    {
        return 'chatgpt' === $name;
    }

    public function getName(): string
    {
        $array = explode('\\', get_class($this));

        return end($array);
    }
}

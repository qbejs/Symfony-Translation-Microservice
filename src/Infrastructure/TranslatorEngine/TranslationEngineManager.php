<?php

namespace App\Infrastructure\TranslatorEngine;

use App\Domain\Interface\Translator\TranslatorInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class TranslationEngineManager
{
    private iterable $translators;
    private string $defaultProvider;

    public function __construct(#[TaggedIterator('app.translator.provider')] iterable $translators, string $defaultProvider)
    {
        $this->translators = $translators;
        $this->defaultProvider = $defaultProvider;
    }

    private function getTranslator(): ?TranslatorInterface
    {
        foreach ($this->translators as $translator) {
            if ($translator->isSupported($this->defaultProvider)) {
                return $translator;
            }
        }

        return null;
    }

    public function translate(string $source, string $target, string $text): string
    {
        $translator = $this->getTranslator();

        if (!$translator) {
            throw new \Exception('No translator found');
        }

        return $translator->translate($source, $target, $text);
    }

    public function getProviderName(): string
    {
        return $this->getTranslator()?->getName() ?? 'No provider found';
    }
}

<?php

namespace App\Application\Translator\Event;

class TranslationCreatedEvent
{
    public string $translationId;

    public function __construct(int $translationId)
    {
        $this->translationId = $translationId;
    }
}

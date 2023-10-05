<?php

namespace App\Application\Language\Event;

class LanguageDeletedEvent
{
    public string $languageId;

    public function __construct(int $languageId)
    {
        $this->languageId = $languageId;
    }
}
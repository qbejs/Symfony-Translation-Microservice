<?php

namespace App\Application\Language\Query;

class GetLanguageByIdQuery
{
    public function __construct(private int $languageId) {}

    public function getLanguageId(): int
    {
        return $this->languageId;
    }
}
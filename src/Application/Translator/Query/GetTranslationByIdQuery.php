<?php

namespace App\Application\Translator\Query;

class GetTranslationByIdQuery
{
    public function __construct(private int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
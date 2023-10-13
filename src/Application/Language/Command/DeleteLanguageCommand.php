<?php

namespace App\Application\Language\Command;

class DeleteLanguageCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}

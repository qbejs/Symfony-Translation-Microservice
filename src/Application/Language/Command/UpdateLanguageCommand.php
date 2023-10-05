<?php

namespace App\Application\Language\Command;

class UpdateLanguageCommand
{
    public int $id;
    public ?string $name;
    public ?string $code;

    public function __construct(int $id, ?string $name = null, ?string $code = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
    }
}
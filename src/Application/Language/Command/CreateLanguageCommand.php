<?php

namespace App\Application\Language\Command;

class CreateLanguageCommand
{
    public string $name;
    public string $code;
    public bool $public;
    public bool $microservice;

    public function __construct(string $name, string $code, bool $public, bool $microservice)
    {
        $this->name = $name;
        $this->code = $code;
        $this->public = $public;
        $this->microservice = $microservice;
    }
}

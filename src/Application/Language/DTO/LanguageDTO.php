<?php

namespace App\Application\Language\DTO;

use Prugala\RequestDto\Dto\RequestDtoInterface;

class LanguageDTO implements RequestDtoInterface
{
    public ?int $id;
    public ?string $name;
    public ?string $code;
    public ?bool $public;
    public ?bool $microservice;

    public function __construct(?int $id = null, ?string $name = null, ?string $code = null, ?bool $public = null, ?bool $microservice = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->code = $code;
        $this->public = $public;
        $this->microservice = $microservice;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'public' => $this->public,
            'microservice' => $this->microservice,
        ];
    }
}
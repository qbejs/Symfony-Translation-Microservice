<?php

namespace App\Application\Language\DTO;

use App\Infrastructure\Validator\Constraint\LanguageCode;
use Prugala\RequestDto\Dto\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LanguageDTO implements RequestDtoInterface
{
    #[Assert\Positive]
    public ?int $id;
    public ?string $createdAt = null;
    public ?string $updatedAt = null;
    public ?string $deletedAt = null;
    public ?string $name;
    #[LanguageCode]
    public ?string $code;
    public ?bool $public;
    public ?bool $microservice;

    public function __construct(
        int $id = null,
        string $createdAt = null,
        string $updatedAt = null,
        string $deletedAt = null,
        string $name = null,
        string $code = null,
        bool $public = null,
        bool $microservice = null
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
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

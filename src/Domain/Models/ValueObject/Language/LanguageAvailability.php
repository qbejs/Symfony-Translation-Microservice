<?php

namespace App\Domain\Models\ValueObject\Language;

class LanguageAvailability
{
    private array $availability;
    private bool $publicMicroservice;
    private bool $microservice;

    public function __construct(bool $publicMicroservice, bool $microservice)
    {
        $this->publicMicroservice = $publicMicroservice;
        $this->microservice = $microservice;
        $this->availability = [
            'public' => $publicMicroservice,
            'microservice' => $microservice,
        ];
    }

    public function getValue(): array
    {
        return $this->availability;
    }

    public function isAvailableInPublic(): bool
    {
        return $this->publicMicroservice;
    }

    public function isAvailableInMicroservice(): bool
    {
        return $this->microservice;
    }
}

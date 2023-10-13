<?php

namespace App\Application\Translator\Query;

class ResultRegistry
{
    private array $results = [];

    public function set(string $queryName, $result): void
    {
        $this->results[$queryName] = $result;
    }

    public function get(string $queryName)
    {
        return $this->results[$queryName] ?? null;
    }
}

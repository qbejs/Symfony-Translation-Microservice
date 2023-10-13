<?php

namespace App\Domain\Interface;

use App\Domain\Models\Translation;

interface TranslationRepositoryInterface
{
    public function find(int $id): ?Translation;

    public function findAll(): array;

    public function save(Translation $language): void;

    public function delete(Translation $language): void;
}

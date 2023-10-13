<?php

namespace App\Domain\Interface;

use App\Domain\Models\Language;

interface LanguageRepositoryInterface
{
    public function find(int $id): ?Language;

    public function findAll(): array;

    public function save(Language $language): void;

    public function delete(Language $language): void;
}

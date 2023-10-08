<?php

namespace App\Infrastructure\Security\Interface;

interface BlacklistManagerInterface
{
    public function addTokenToBlacklist(string $token, int $ttl): void;
    public function isTokenInBlacklist(string $token): bool;
    public function isSupported(): bool;
}
<?php

namespace App\Domain\Interface\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface TokenManagerInterface
{
    public function getName(): string;
    public function isSupported(): bool;
    public function createFromPayload(UserInterface $user, array $payload = []): string;
    public function parse(string $token): array;
    public function create(UserInterface $user): string;
    public function decode(TokenInterface $token);
    public function setUserIdentityField($field);
    public function getUserIdentityField();
    public function getUserIdClaim();
}
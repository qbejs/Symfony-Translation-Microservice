<?php

namespace App\Infrastructure\Security\Adapter\TokenManager;

use App\Domain\Interface\Security\TokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LexikTokenAdapter implements TokenManagerInterface
{
    private JWTTokenManagerInterface $lexikJWTManager;
    private string $secretKey;

    public function __construct(JWTTokenManagerInterface $lexikJWTManager)
    {
        $this->lexikJWTManager = $lexikJWTManager;
    }

    public function create(UserInterface $user): string
    {
        return $this->lexikJWTManager->create($user);
    }

    public function createFromPayload(UserInterface $user, array $payload = []): string
    {
        return $this->lexikJWTManager->createFromPayload($user, $payload);
    }

    public function parse(string $token): array
    {
        return $this->lexikJWTManager->parse($token);
    }

    /**
     * @throws JWTDecodeFailureException
     */
    public function decode(TokenInterface $token): array
    {
        return $this->lexikJWTManager->decode($token);
    }

    public function setUserIdentityField($field): void
    {
        $this->lexikJWTManager->setUserIdentityField($field);
    }

    public function getUserIdentityField(): string
    {
        return $this->lexikJWTManager->getUserIdentityField();
    }

    public function getUserIdClaim(): string
    {
        return $this->lexikJWTManager->getUserIdClaim();
    }

    public function getName(): string
    {
        return 'lexik';
    }

    public function isSupported(): bool
    {
        return true;
    }
}
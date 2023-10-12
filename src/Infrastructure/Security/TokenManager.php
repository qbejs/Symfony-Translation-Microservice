<?php

namespace App\Infrastructure\Security;

use App\Domain\Interface\Security\TokenManagerInterface;
use App\Infrastructure\Security\Exception\TokenAdapterNotFoundException;
use App\Infrastructure\Security\Exception\TokenAdapterUnsupportedException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TokenManager
{
    private iterable $adapters;

    public function __construct(#[TaggedIterator('app.token.manager')] iterable $adapters)
    {
        $this->adapters = $adapters;
    }

    private function getAdapterByName(string $name): ?TokenManagerInterface
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->getName() === $name) {
                return $adapter;
            }
        }
        throw new TokenAdapterNotFoundException($name);
    }

    private function getSupportedAdapter(): ?TokenManagerInterface
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->isSupported()) {
                return $adapter;
            }
        }
        throw new TokenAdapterUnsupportedException();
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function create(UserInterface $user): string
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->create($user);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function decode(TokenInterface $token): array
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->decode($token);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function setUserIdentityField($field): void
    {
        $adapter = $this->getSupportedAdapter();

        $adapter->setUserIdentityField($field);
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getUserIdentityField(): string
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->getUserIdentityField();
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function getUserIdClaim(): string
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->getUserIdClaim();
    }

    /**
     * @throws \Exception
     */
    public function createFromPayload(UserInterface $user, array $payload = []): string
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->createFromPayload($user, $payload);
    }

    /**
     * @throws \Exception
     */
    public function parse(string $token): array
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->parse($token);
    }

}
<?php

namespace App\Infrastructure\Security;

use App\Infrastructure\Security\Exception\BlacklistAdapterUnsupportedException;
use App\Infrastructure\Security\Interface\BlacklistManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class BlacklistManager
{
    private iterable $adapters;

    public function __construct(#[TaggedIterator('app.blacklist.manager')] iterable $adapters)
    {
        $this->adapters = $adapters;
    }

    /**
     * @throws BlacklistAdapterUnsupportedException
     */
    public function add(string $token, int $ttl): void
    {
        $adapter = $this->getSupportedAdapter();

        $adapter->addTokenToBlacklist($token, $ttl);
    }

    /**
     * @throws BlacklistAdapterUnsupportedException
     */
    public function isBlacklisted(string $token): bool
    {
        $adapter = $this->getSupportedAdapter();

        return $adapter->isTokenInBlacklist($token);
    }

    private function getSupportedAdapter(): ?BlacklistManagerInterface
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->isSupported()) {
                return $adapter;
            }
        }
        throw new BlacklistAdapterUnsupportedException();
    }
}
<?php

namespace App\Infrastructure\Security\Adapter\BlacklistManager;

use App\Domain\Interface\Security\BlacklistManagerInterface;
use App\Infrastructure\Security\Adapter\BlacklistManager\Exception\UserTokenNotFound;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Predis\ClientInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RedisBlacklistAdapter implements BlacklistManagerInterface
{
    private ClientInterface $redisAdapter;
    private TokenStorageInterface $tokenStorage;
    private JWTTokenManagerInterface $jwtManager;

    public function __construct(string $redisConnectionString, TokenStorageInterface $tokenStorage, JWTTokenManagerInterface $jwtManager)
    {
        $this->redisAdapter = RedisAdapter::createConnection($redisConnectionString);
        $this->tokenStorage = $tokenStorage;
        $this->jwtManager = $jwtManager;
    }

    public function addTokenToBlacklist(string $token, int $ttl = 111600): void
    {
        $this->redisAdapter->set($token, true, $ttl);
    }

    public function isTokenInBlacklist(string $token): bool
    {
        return $this->redisAdapter->exists($token);
    }

    /**
     * @throws UserTokenNotFound
     * @throws \RedisException
     */
    public function addTokenToBlacklistFromUser(UserInterface $user): void
    {
        $userTokenData = $this->extractTokenAndExpFromUser($user);

        if (null === $userTokenData) {
            return;
        }

        $this->redisAdapter->set($userTokenData[0], true, $userTokenData[1]);
    }

    private function extractTokenAndExpFromUser(UserInterface $user): ?array
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token || $token->getUser() !== $user) {
            throw new UserTokenNotFound();
        }

        $decodedToken = $this->jwtManager->decode($token);
        $expirationTime = $decodedToken['exp'];
        $ttl = $expirationTime - time();

        if ($ttl <= 0) {
            return null;
        }

        return [$token->getCredentials(), $ttl];
    }

    public function isSupported(): bool
    {
        return true;
    }
}

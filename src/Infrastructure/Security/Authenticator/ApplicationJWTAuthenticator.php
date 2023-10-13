<?php

namespace App\Infrastructure\Security\Authenticator;

use App\Domain\Models\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\JWTAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class ApplicationJWTAuthenticator extends JWTAuthenticator
{
    private TokenExtractorInterface $tokenExtractor;

    private JWTTokenManagerInterface $jwtManager;

    private EventDispatcherInterface $eventDispatcher;

    private UserProviderInterface $userProvider;

    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        \Symfony\Contracts\EventDispatcher\EventDispatcherInterface $eventDispatcher,
        TokenExtractorInterface $tokenExtractor,
        UserProviderInterface $userProvider,
    ) {
        parent::__construct($jwtManager, $eventDispatcher, $tokenExtractor, $userProvider);
        $this->eventDispatcher = $eventDispatcher;
        $this->jwtManager = $jwtManager;
        $this->tokenExtractor = $tokenExtractor;
        $this->userProvider = $userProvider;
    }

    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        /** @var User $user */
        $user = $passport->getUser();
        $passportToken = $passport->getAttribute('token');
        $roles = $user->getRoles();
        if ($passportToken) {
            $parsedToken = $this->jwtManager->parse($passportToken);
            if (isset($parsedToken['roles'])) {
                $roles = $parsedToken['roles'];
            }
        }

        $tokenPayload = $passport->getAttribute('payload');

        $token = new JWTPostAuthenticationToken($passport->getUser(), $firewallName, $roles, $passportToken);

        $this->eventDispatcher->dispatch(new JWTAuthenticatedEvent($tokenPayload, $token), Events::JWT_AUTHENTICATED);

        return $token;
    }

    public function authenticate(\Symfony\Component\HttpFoundation\Request $request): Passport
    {
        $token = $this->tokenExtractor->extract($request);
        if (!$token) {
            throw new AuthenticationException('No JWT token found');
        }

        $credentials = new CustomCredentials(
            function ($credentials) {
                // TO DO: Additional validation of the token
                return true;
            },
            $token
        );

        return new Passport(
            new UserBadge($token, function ($userIdentifier) {
                return $this->userProvider->loadUserByIdentifier($userIdentifier);
            }),
            $credentials
        );
    }
}

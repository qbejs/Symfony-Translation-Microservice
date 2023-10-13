<?php

namespace App\Application\User\Service;

use App\Domain\Factory\UserFactory;
use App\Domain\Interface\ServiceInterface;
use App\Domain\Interface\UserRepositoryInterface;
use App\Domain\Models\User;
use App\Domain\Models\ValueObject\User\Password;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements ServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function getResultFromMessage(Envelope $message): mixed
    {
        return $message->last(HandledStamp::class)->getResult();
    }

    public function createUser(string $username, string $email, string $password): ?User
    {
        try {
            $userFactory = new UserFactory();
            $user = $userFactory->create($username, $email, null);
            $user->setPassword(new Password($this->userPasswordHasher->hashPassword($user, $password)));
            $this->userRepository->save($user);

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }
}

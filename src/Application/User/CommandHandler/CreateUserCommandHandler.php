<?php

namespace App\Application\User\CommandHandler;

use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Service\UserService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = $this->userService->createUser($command->username, $command->email, $command->password);

        if (null === $user) {
            throw new \Exception('User not created');
        }

        // Dispatch event for user created notification
    }
}

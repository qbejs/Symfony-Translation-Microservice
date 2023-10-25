<?php

namespace App\Application\User\CommandHandler;

use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Service\UserService;
use App\Infrastructure\EventSubscriber\Backoffice\Notificator\Event\DispatchNotificationEvent;
use App\Infrastructure\Notifier\SupportedNotificationTypesEnum;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    public function __construct(private readonly UserService $userService, private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = $this->userService->createUser($command->username, $command->email, $command->password);

        if (null === $user) {
            throw new \Exception('User not created');
        }

        $this->eventDispatcher->dispatch(new DispatchNotificationEvent(
            SupportedNotificationTypesEnum::EMAIL->value,
            'user_created',
            $command->email,
            ['username' => $command->username, 'id' => $user->getId()]
        ), 'notification.dispatched');
    }
}

<?php

namespace App\UI\Controller;

use App\Application\User\Command\CreateUserCommand;
use App\Domain\Models\DTO\UserDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route(path: '/user', name: 'user', methods: ['GET'])]
    public function index(): Response
    {
        return new Response('User', 200);
    }

    #[Route(path: '/user/{id}', name: 'user_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return new Response("User $id", 200);
    }

    #[Route(path: '/user', name: 'user_create', methods: ['POST'])]
    public function create(UserDTO $dto): Response
    {
        $this->messageBus->dispatch(new CreateUserCommand($dto->username, $dto->email, $dto->password));

        return new Response('User created', 201);
    }
}

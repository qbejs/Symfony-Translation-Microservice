<?php

namespace App\Application\Language\Controller;

use App\Application\Language\Command\CreateLanguageCommand;
use App\Application\Language\Command\UpdateLanguageCommand;
use App\Application\Language\DTO\LanguageDTO;
use App\Application\Language\Event\LanguageCreatedEvent;
use App\Application\Language\Event\LanguageDeletedEvent;
use App\Application\Language\Event\LanguageUpdatedEvent;
use App\Application\Language\Query\GetLanguageByIdQuery;
use App\Application\Language\Query\GetLanguagesQuery;
use App\Application\Language\Service\LanguageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LanguageController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $queryBus,
                                private readonly SerializerInterface $serializer,
                                private readonly LanguageService $languageService)
    {
    }

    #[Route(path: '/language/{id}', name: 'language.by.id', methods: ['GET'])]
    public function getLanguageById(int $id): JsonResponse
    {
        $query = new GetLanguageByIdQuery($id);
        $language = $this->queryBus->dispatch($query);

        return new JsonResponse($this->serializer->serialize($this->languageService->getResultFromMessage($language), 'json'), Response::HTTP_OK, [], true);
    }

    #[Route(path: '/language', name: 'language.all', methods: ['GET'])]
    public function getAllLanguages(): JsonResponse
    {
        $query = new GetLanguagesQuery();
        $language = $this->queryBus->dispatch($query);

        return new JsonResponse($this->serializer->serialize($this->languageService->getResultFromMessage($language), 'json'), Response::HTTP_OK, [], true);
    }

    #[Route(path: '/language', name: 'language.create', methods: ['POST'])]
    public function createLanguage(LanguageDTO $dto): Response
    {
        $this->queryBus->dispatch(new CreateLanguageCommand($dto->name, $dto->code, $dto->public, $dto->microservice));

        return new Response('Resource created', Response::HTTP_CREATED);
    }

    #[Route(path: '/language/{id}', name: 'language.update', methods: ['PUT'])]
    public function updateLanguage(int $id, LanguageDTO $dto): Response
    {
        $this->queryBus->dispatch(new UpdateLanguageCommand($id, $dto->name, $dto->code));

        return new Response('Resource updated', Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/language/{id}', name: 'language.delete', methods: ['DELETE'])]
    public function deleteLanguage(int $id): Response
    {
        $this->queryBus->dispatch(new LanguageDeletedEvent($id));

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}

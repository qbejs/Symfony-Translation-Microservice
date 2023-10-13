<?php

namespace App\Application\Translator\Controller;

use App\Application\Translator\Command\CreateTranslationCommand;
use App\Application\Translator\DTO\TranslationDTO;
use App\Application\Translator\Query\GetTranslationByIdQuery;
use App\Application\Translator\Query\GetTranslationsQuery;
use App\Application\Translator\Service\TranslatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TranslationController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $queryBus,
        private readonly TranslatorService $translationService,
        private readonly SerializerInterface $serializer)
    {
    }

    #[Route(path: '/translation', name: 'translation.all', methods: ['GET'])]
    public function getAllTranslations(): JsonResponse
    {
        $query = new GetTranslationsQuery();
        $translation = $this->queryBus->dispatch($query);

        return new JsonResponse($this->serializer->serialize($this->translationService->getResultFromMessage($translation), 'json', ['groups' => ['translation']]), Response::HTTP_OK, [], true);
    }

    #[Route(path: '/translation/{id}', name: 'translation.one', methods: ['GET'])]
    public function getTranslation(int $id): JsonResponse
    {
        $query = new GetTranslationByIdQuery($id);
        $translation = $this->queryBus->dispatch($query);

        return new JsonResponse($this->serializer->serialize($this->translationService->getResultFromMessage($translation), 'json', ['groups' => ['translation']]), Response::HTTP_OK, [], true);
    }

    #[Route(path: '/translation', name: 'translation.create', methods: ['POST'])]
    public function createTranslation(TranslationDTO $dto): Response
    {
        $this->queryBus->dispatch(new CreateTranslationCommand($dto->languageId, $dto->source, $dto->text, $dto->externalId, $dto->externalName));

        return new Response('Resource created', Response::HTTP_CREATED);
    }

    //    #[Route(path: '/translation/{id}', name: 'translation.update', methods: ['PUT'])]
    //    public function updateTranslation(int $id, TranslationDTO $dto): Response
    //    {
    //        $this->queryBus->dispatch(new UpdateTranslationCommand($id, $dto->name, $dto->code));
    //
    //        return new Response('Resource updated', Response::HTTP_OK);
    //    }
    //
    //    #[Route(path: '/translation/{id}', name: 'translation.delete', methods: ['DELETE'])]
    //    public function deleteTranslation(int $id): Response
    //    {
    //        $this->queryBus->dispatch(new DeleteTranslationCommand($id));
    //
    //        return new Response('Resource deleted', Response::HTTP_OK);
    //    }
}

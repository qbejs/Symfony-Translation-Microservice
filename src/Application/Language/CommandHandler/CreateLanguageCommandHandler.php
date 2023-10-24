<?php

namespace App\Application\Language\CommandHandler;

use App\Application\Language\Command\CreateLanguageCommand;
use App\Application\Language\Event\LanguageCreatedEvent;
use App\Domain\Factory\LanguageFactory;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Models\DTO\LanguageDTO;
use App\Infrastructure\Repository\Doctrine\LanguageRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
class CreateLanguageCommandHandler
{
    private LanguageFactory $languageFactory;
    private LanguageRepositoryInterface $languageRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(LanguageFactory $languageFactory, LanguageRepository $languageRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->languageFactory = $languageFactory;
        $this->languageRepository = $languageRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(CreateLanguageCommand $command)
    {
        $dto = new LanguageDTO();
        $dto->name = $command->name;
        $dto->code = $command->code;
        $dto->public = $command->public;
        $dto->microservice = $command->microservice;

        $language = $this->languageFactory->createFromDTO($dto);
        $this->languageRepository->save($language);

        $event = new LanguageCreatedEvent($language->getId()->getValue());
        $this->eventDispatcher->dispatch($event, 'language.created');
    }
}

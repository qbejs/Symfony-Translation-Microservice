<?php

namespace App\Application\Language\CommandHandler;

use App\Application\Language\Command\DeleteLanguageCommand;
use App\Application\Language\Event\LanguageDeletedEvent;
use App\Domain\Interface\LanguageRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteLanguageCommandHandler
{
    private LanguageRepositoryInterface $languageRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(LanguageRepositoryInterface $languageRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->languageRepository = $languageRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(DeleteLanguageCommand $command)
    {
        $language = $this->languageRepository->find($command->id);

        if (!$language) {
            throw new \Exception("Language with ID {$command->id} not found");
        }

        $this->languageRepository->delete($language);

        $event = new LanguageDeletedEvent($language->getId()->getValue());
        $this->eventDispatcher->dispatch($event, 'language.deleted');
    }
}

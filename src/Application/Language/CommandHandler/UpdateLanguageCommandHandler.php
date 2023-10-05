<?php

namespace App\Application\Language\CommandHandler;

use App\Application\Language\Command\UpdateLanguageCommand;
use App\Application\Language\Event\LanguageUpdatedEvent;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Models\ValueObject\Language\LanguageCode;
use App\Domain\Models\ValueObject\Language\LanguageName;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
class UpdateLanguageCommandHandler
{
    private LanguageRepositoryInterface $languageRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(LanguageRepositoryInterface $languageRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->languageRepository = $languageRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(UpdateLanguageCommand $command)
    {
        $language = $this->languageRepository->find($command->id);

        if (!$language) {
            throw new \Exception("Language with ID {$command->id} not found");
        }

        $language->setName(new LanguageName($command->name));
        $language->setCode(new LanguageCode($command->code));

        $this->languageRepository->save($language);

        $event = new LanguageUpdatedEvent($language->getId()->getValue());
        $this->eventDispatcher->dispatch($event, 'language.updated');
    }
}
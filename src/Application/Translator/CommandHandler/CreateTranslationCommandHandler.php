<?php

namespace App\Application\Translator\CommandHandler;

use App\Application\Translator\Command\CreateTranslationCommand;
use App\Application\Translator\Event\TranslationCreatedEvent;
use App\Application\Translator\Service\TranslatorService;
use App\Domain\Factory\Interface\TranslationFactoryInterface;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Interface\TranslationRepositoryInterface;
use App\Domain\Models\DTO\TranslationDTO;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[AsMessageHandler]
class CreateTranslationCommandHandler
{
    private TranslationFactoryInterface $translationFactory;
    private TranslationRepositoryInterface $translationRepository;
    private EventDispatcherInterface $eventDispatcher;
    private LanguageRepositoryInterface $languageRepository;

    public function __construct(
        TranslationFactoryInterface $translationFactory,
        TranslationRepositoryInterface $translationRepository,
        LanguageRepositoryInterface $languageRepository,
        EventDispatcherInterface $eventDispatcher,
        private readonly TranslatorService $translatorService
    ) {
        $this->translationFactory = $translationFactory;
        $this->translationRepository = $translationRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateTranslationCommand $command)
    {
        $dto = new TranslationDTO();
        $dto->source = $command->source;
        $dto->languageId = $command->target;
        $dto->text = $command->text;
        $dto->externalId = $command->externalId;
        $dto->externalName = $command->externalName;

        $desiredLang = $this->languageRepository->find($command->target);
        $sourceLang = $this->languageRepository->find($command->source);

        if (!$desiredLang || !$sourceLang) {
            throw new \Exception('Language not found');
        }

        $dto->translated = $this->translatorService->createTranslation($sourceLang->getCode()->getValue(), $desiredLang->getCode()->getValue(), $command->text);

        $translation = $this->translationFactory->createFromDTO($dto);
        $this->translationRepository->save($translation);

        $event = new TranslationCreatedEvent($translation->getId()->getValue());
        $this->eventDispatcher->dispatch($event, 'translation.created');
    }
}

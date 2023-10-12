<?php

namespace App\Tests\Unit\Commands;

use App\Application\Translator\Command\CreateTranslationCommand;
use App\Application\Translator\CommandHandler\CreateTranslationCommandHandler;
use App\Application\Translator\Event\TranslationCreatedEvent;
use App\Tests\Unit\BaseTest;

class CreateTranslationCommandHandlerTest extends BaseTest
{
    /**
     * @throws \Exception
     */
    public function testInvokeCreatesTranslation(): void
    {
        // Mock Languages
        $sourceLanguage = $this->mockLanguage(9, 'Polski', 'pl', true, true);
        $targetLanguage = $this->mockLanguage(10, 'English', 'en', true, true);

        // Mock LanguageRepository to return the expected Language objects (Factory decorator)
        $mockedLanguageRepo = $this->mockLanguageRepositoryResultForDecorator($sourceLanguage, $targetLanguage);

        // Mock the command
        $command = new CreateTranslationCommand(9, 10, 'Witaj świecie!', null, null);

        // Mock the expected DTO to be produced by the handler
        $dto = $this->createTranslationDTOFromCommand($command);

        // Mocked translation object
        $mockedTranslation = $this->mockTranslation('Witaj świecie!', 'Hello world!', $sourceLanguage, $targetLanguage);

        // Define expectations
        $this->setExpectations($dto, $mockedTranslation, TranslationCreatedEvent::class);

        // Instantiate the handler with the mocked dependencies and invoke it
        $handler = new CreateTranslationCommandHandler($this->translationFactory, $this->translationRepository, $mockedLanguageRepo, $this->eventDispatcher, $this->translationService);
        $handler->__invoke($command);
    }
}

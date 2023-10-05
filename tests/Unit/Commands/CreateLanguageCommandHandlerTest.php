<?php

namespace App\Tests\Unit\Commands;

use App\Application\Language\Command\CreateLanguageCommand;
use App\Application\Language\CommandHandler\CreateLanguageCommandHandler;
use App\Application\Language\Event\LanguageCreatedEvent;
use App\Tests\Unit\BaseTest;

class CreateLanguageCommandHandlerTest extends BaseTest
{
    public function testInvokeCreatesLanguage(): void
    {
        $command = new CreateLanguageCommand('Polski', 'pl', true, true);

        // Mock the expected DTO to be produced by the handler
        $dto = $this->createLanguageDTOFromCommand($command);

        // Mocked language object
        $mockedLanguage = $this->mockLanguage(1, 'Polski', 'pl', true, true);

        // Define expectations
        $this->setExpectations($dto, $mockedLanguage, LanguageCreatedEvent::class);

        // Instantiate the handler with the mocked dependencies and invoke it
        $handler = new CreateLanguageCommandHandler($this->languageFactory, $this->languageRepository, $this->eventDispatcher);
        $handler->__invoke($command);
    }
}
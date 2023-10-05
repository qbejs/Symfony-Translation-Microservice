<?php

namespace App\Tests\Unit\Commands;

use App\Application\Language\Command\UpdateLanguageCommand;
use App\Application\Language\CommandHandler\UpdateLanguageCommandHandler;
use App\Application\Language\Event\LanguageUpdatedEvent;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\ValueObject\Language\LanguageCode;
use App\Domain\Models\ValueObject\Language\LanguageId;
use App\Domain\Models\ValueObject\Language\LanguageName;
use App\Tests\Unit\BaseTest;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateLanguageCommandHandlerTest extends BaseTest
{
    public function testUpdateSuccessfully()
    {
        $command = new UpdateLanguageCommand(1, 'pl', 'Polski');

        $mockedLanguage = $this->createMock(Language::class);
        $mockedLanguage->expects($this->once())->method('setName')->with(new LanguageName($command->name));
        $mockedLanguage->expects($this->once())->method('setCode')->with(new LanguageCode($command->code));
        $mockedLanguage->method('getId')->willReturn(new LanguageId($command->id));

        $repository = $this->createMock(LanguageRepositoryInterface::class);
        $repository->expects($this->once())->method('find')->with($command->id)->willReturn($mockedLanguage);
        $repository->expects($this->once())->method('save')->with($mockedLanguage);

        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(LanguageUpdatedEvent::class), 'language.updated');

        $handler = new UpdateLanguageCommandHandler($repository, $dispatcher);
        $handler->__invoke($command);
    }

    public function testUpdateThrowsExceptionForMissingLanguage()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Language with ID 1 not found');

        $command = new UpdateLanguageCommand(1, 'pl', 'Polski');

        $repository = $this->createMock(LanguageRepositoryInterface::class);
        $repository->expects($this->once())->method('find')->with($command->id)->willReturn(null);

        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $dispatcher->expects($this->never())->method('dispatch');

        $handler = new UpdateLanguageCommandHandler($repository, $dispatcher);
        $handler->__invoke($command);
    }
}
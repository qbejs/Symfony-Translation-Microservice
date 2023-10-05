<?php

namespace App\Tests\Unit\Commands;

use App\Application\Language\Command\DeleteLanguageCommand;
use App\Application\Language\CommandHandler\DeleteLanguageCommandHandler;
use App\Application\Language\Event\LanguageDeletedEvent;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\ValueObject\Language\LanguageId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteLanguageCommandHandlerTest extends TestCase
{
    private $languageRepositoryMock;
    private $eventDispatcherMock;

    protected function setUp(): void
    {
        $this->languageRepositoryMock = $this->createMock(LanguageRepositoryInterface::class);
        $this->eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
    }

    public function testItDeletesLanguageAndDispatchesAnEvent()
    {
        $languageId = 123;

        $languageMock = $this->createMock(Language::class);
        $languageMock->method('getId')->willReturn(new LanguageId($languageId));

        $this->languageRepositoryMock->expects($this->once())
            ->method('find')
            ->with($languageId)
            ->willReturn($languageMock);

        $this->languageRepositoryMock->expects($this->once())
            ->method('delete')
            ->with($languageMock);

        $this->eventDispatcherMock->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(LanguageDeletedEvent::class), 'language.deleted');

        $handler = new DeleteLanguageCommandHandler($this->languageRepositoryMock, $this->eventDispatcherMock);

        $command = new DeleteLanguageCommand($languageId);
        $handler($command);
    }

    public function testItThrowsExceptionWhenLanguageNotFound()
    {
        $languageId = 123;

        $this->languageRepositoryMock->expects($this->once())
            ->method('find')
            ->with($languageId)
            ->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Language with ID {$languageId} not found");

        $handler = new DeleteLanguageCommandHandler($this->languageRepositoryMock, $this->eventDispatcherMock);
        $command = new DeleteLanguageCommand($languageId);
        $handler($command);
    }
}

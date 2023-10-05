<?php

namespace App\Tests\Unit;

use App\Application\Language\DTO\LanguageDTO;
use App\Application\Translator\DTO\TranslationDTO;
use App\Application\Translator\Event\TranslationCreatedEvent;
use App\Application\Translator\Service\TranslatorService;
use App\Domain\Factory\LanguageFactory;
use App\Domain\Factory\TranslationFactory;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Interface\TranslationRepositoryInterface;
use App\Domain\Models\Language;
use App\Domain\Models\Translation;
use App\Domain\Models\ValueObject\Language\LanguageAvailability;
use App\Domain\Models\ValueObject\Language\LanguageCode;
use App\Domain\Models\ValueObject\Language\LanguageId;
use App\Domain\Models\ValueObject\Language\LanguageName;
use App\Domain\Models\ValueObject\Translation\SourceText;
use App\Domain\Models\ValueObject\Translation\Translated;
use App\Domain\Models\ValueObject\Translation\TranslationId;
use App\Infrastructure\Doctrine\Repository\LanguageRepository;
use PHPUnit\Framework\MockObject\MockClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class BaseTest extends TestCase
{
    protected $translationFactory;
    protected $languageFactory;
    protected $translationRepository;
    protected $languageRepository;
    protected $translationService;
    protected $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the dependencies
        $this->translationFactory = $this->createMock(TranslationFactory::class);
        $this->languageFactory = $this->createMock(LanguageFactory::class);
        $this->translationRepository = $this->createMock(TranslationRepositoryInterface::class);
        $this->languageRepository = $this->createMock(LanguageRepository::class);
        $this->translationService = $this->createMock(TranslatorService::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function mockLanguage($id, $name, $code, $public, $microservice): Language
    {
        $language = $this->createMock(Language::class);
        $language->method('getId')->willReturn(new LanguageId($id));
        $language->method('getName')->willReturn(new LanguageName($name));
        $language->method('getCode')->willReturn(new LanguageCode($code));
        $language->method('getAvailability')->willReturn(new LanguageAvailability($public, $microservice));

        return $language;
    }

    public function mockTranslation(string $sourceText, string $translatedText, Language $sourceLang, Language $targetLang): Translation
    {
        $translation = $this->createMock(Translation::class);
        $translation->method('getId')->willReturn(new TranslationId(1));
        $translation->method('getSourceText')->willReturn(new SourceText($sourceText));
        $translation->method('getTranslated')->willReturn(new Translated($translatedText));
        $translation->method('getSource')->willReturn($sourceLang);
        $translation->method('getLanguage')->willReturn($targetLang);

        return $translation;

    }

    public function mockLanguageRepositoryResultForDecorator(Language $source, Language $target): LanguageRepositoryInterface
    {
        $repository = $this->createMock(LanguageRepositoryInterface::class);
        $repository->method('find')
            ->willReturnCallback(function ($id) use ($source, $target) {
                if ($id === $source->getId()->getValue()) return $source;
                if ($id === $target->getId()->getValue()) return $target;
                return null;
            });

        return $repository;
    }

    protected function createTranslationDTOFromCommand($command): TranslationDTO
    {
        $dto = new TranslationDTO();
        $dto->source = $command->source;
        $dto->languageId = $command->target;
        $dto->text = $command->text;

        return $dto;
    }

    protected function createLanguageDTOFromCommand($command): LanguageDTO
    {
        $dto = new LanguageDTO();
        $dto->name = $command->name;
        $dto->code = $command->code;
        $dto->public = $command->public;
        $dto->microservice = $command->microservice;

        return $dto;
    }

    protected function setExpectations($dto, $mockedEntity, string $eventType): void
    {
        if ($mockedEntity instanceof Translation) {
            $this->translationFactory->expects($this->once())
                ->method('createFromDTO')
                ->with($dto)
                ->willReturn($mockedEntity);

            $this->translationRepository->expects($this->once())
                ->method('save')
                ->with($mockedEntity);

            $this->eventDispatcher->expects($this->once())
                ->method('dispatch')
                ->with($this->isInstanceOf($eventType), 'translation.created');
        } elseif ($mockedEntity instanceof Language) {
            $this->languageFactory->expects($this->once())  // Używamy languageFactory zamiast translationFactory
            ->method('createFromDTO')
                ->with($dto)
                ->willReturn($mockedEntity);

            $this->languageRepository->expects($this->once())
                ->method('save')
                ->with($mockedEntity);

            $this->eventDispatcher->expects($this->once())
                ->method('dispatch')
                ->with($this->isInstanceOf($eventType), 'language.created');
        } else {
            throw new \InvalidArgumentException("Unsupported entity type for expectations.");
        }
    }


//    protected function setExpectations($dto, $mockedTranslation): void
//    {
//        $this->translationFactory->expects($this->once())
//            ->method('createFromDTO')
//            ->with($dto)
//            ->willReturn($mockedTranslation);
//
//        $this->translationRepository->expects($this->once())
//            ->method('save')
//            ->with($mockedTranslation);
//
//        $this->eventDispatcher->expects($this->once())
//            ->method('dispatch')
//            ->with($this->isInstanceOf(TranslationCreatedEvent::class), 'translation.created');
//
//
//    }
}
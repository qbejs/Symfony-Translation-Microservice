<?php

namespace App\Application\Language\Service;

use App\Application\Interface\ServiceInterface;
use App\Application\Language\Command\CreateLanguageCommand;
use App\Application\Language\Command\DeleteLanguageCommand;
use App\Application\Language\Command\UpdateLanguageCommand;
use App\Application\Language\DTO\LanguageDTO;
use App\Application\Language\Query\GetLanguageByIdQuery;
use App\Application\Language\Query\GetLanguagesQuery;
use App\Application\Language\Query\ResultRegistry;
use App\Domain\Models\Language;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class LanguageService implements ServiceInterface
{
    public function __construct(private readonly MessageBusInterface $messageBus, private readonly ResultRegistry $LanguageResultRegistry)
    {
    }

    public function createLanguage(string $name, string $code, bool $public, bool $microservice): bool
    {
        $command = new CreateLanguageCommand($name, $code, $public, $microservice);
        return (bool) $this->messageBus->dispatch($command);
    }

    public function createLanguageFromDTO(LanguageDTO $dto): bool
    {
        $command = new CreateLanguageCommand($dto->name, $dto->code, $dto->public, $dto->microservice);
        return (bool) $this->messageBus->dispatch($command);
    }

    public function updateLanguage(LanguageDTO $dto): bool
    {
        $command = new UpdateLanguageCommand($dto->id, $dto->name, $dto->code);
        return (bool) $this->messageBus->dispatch($command);
    }

    public function deleteLanguage(int $id): void
    {
        $command = new DeleteLanguageCommand($id);
        $this->messageBus->dispatch($command);
    }

    public function getLanguageById(int $id): ?Language
    {
        $query = new GetLanguageByIdQuery($id);
        $this->messageBus->dispatch($query);

        return $this->LanguageResultRegistry->get(GetLanguageByIdQuery::class);
    }

    public function getAllLanguages(): array
    {
        $query = new GetLanguagesQuery();
        $this->messageBus->dispatch($query);

        return $this->LanguageResultRegistry->get(GetLanguagesQuery::class);
    }

    public function getResultFromMessage(Envelope $message): mixed
    {
        return $message->last(HandledStamp::class)->getResult();
    }
}
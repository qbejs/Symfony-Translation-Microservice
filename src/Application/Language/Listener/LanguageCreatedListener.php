<?php

namespace App\Application\Language\Listener;

use App\Application\Language\Event\LanguageCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'language.created', method: 'onLanguageCreated')]
class LanguageCreatedListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLanguageCreated(LanguageCreatedEvent $event): void
    {
        $this->logger->info("Language with ID {$event->languageId} was created.");
    }
}

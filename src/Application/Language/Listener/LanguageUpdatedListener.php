<?php

namespace App\Application\Language\Listener;

use App\Application\Language\Event\LanguageUpdatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'language.updated', method: 'onLanguageUpdated')]
class LanguageUpdatedListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLanguageUpdated(LanguageUpdatedEvent $event): void
    {
        $this->logger->info("Language with ID {$event->languageId} was updated.");
    }
}
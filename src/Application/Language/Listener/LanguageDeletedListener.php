<?php

namespace App\Application\Language\Listener;

use App\Application\Language\Event\LanguageDeletedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'language.deleted', method: 'onLanguageDeleted')]
class LanguageDeletedListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onLanguageDeleted(LanguageDeletedEvent $event): void
    {
        $this->logger->info("Language with ID {$event->languageId} was deleted.");
    }
}

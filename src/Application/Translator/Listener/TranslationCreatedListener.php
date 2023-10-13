<?php

namespace App\Application\Translator\Listener;

use App\Application\Translator\Event\TranslationCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: 'translation.created', method: 'onTranslationCreated')]
class TranslationCreatedListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onTranslationCreated(TranslationCreatedEvent $event): void
    {
        $this->logger->info("Translation with ID {$event->translationId} was created.");
    }
}

<?php

namespace App\Application\Translator\Service;

use App\Application\Translator\Response\Translator\LockedResponse;
use App\Domain\Interface\ServiceInterface;
use App\Domain\Interface\TranslationRepositoryInterface;
use App\Domain\Interface\Translator\TranslatorInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\SemaphoreStore;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class TranslatorService implements ServiceInterface
{
    private iterable $translators;
    private LockFactory $lockFactory;
    private TranslationRepositoryInterface $translationRepository;

    public function __construct(#[TaggedIterator('app.translator.provider')] iterable $translators, TranslationRepositoryInterface $translationRepository)
    {
        $store = new SemaphoreStore();
        $this->lockFactory = new LockFactory($store);
        $this->translators = $translators;
        $this->translationRepository = $translationRepository;

    }

    public function getResultFromMessage(Envelope $message): mixed
    {
        return $message->last(HandledStamp::class)->getResult();
    }

    public function createTranslation(string $source, string $target, string $text): string
    {
        $lock = $this->lockFactory->createLock($text);

        $attempts = 3;
        while(!$lock->acquire(true, 10) && $attempts > 0) {
            sleep(0.5);
            $attempts--;
        }

        if ($attempts == 0) {
            return LockedResponse::response();
        }

        $translator = $this->getTranslator();

        if (!$translator) {
            throw new \Exception('No translator found');
        }

        return $translator->translate($source, $target, $text);
    }

    public function getTranslation(): string
    {
        return "Translation";
    }

    public function getProviderName(): string
    {
        return $this->getTranslator()?->getName() ?? 'No provider found';
    }

    private function getTranslator(): ?TranslatorInterface
    {
        /** @var TranslatorInterface $translator */
        foreach ($this->translators as $translator) {
            if ($translator->isSupported()) {
                return $translator;
            }
        }

        return null;
    }

    private function useExternalTranslationService(string $source, string $target, string $text): string
    {
        $translator = $this->getTranslator();

        if (!$translator) {
            throw new \Exception('No translator found');
        }

        return $translator->translate($source, $target, $text);
    }
}
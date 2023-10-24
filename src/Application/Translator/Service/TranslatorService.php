<?php

namespace App\Application\Translator\Service;

use App\Domain\Interface\ServiceInterface;
use App\Domain\Interface\TranslationRepositoryInterface;
use App\Infrastructure\Response\Translator\LockedResponse;
use App\Infrastructure\TranslatorEngine\TranslationEngineManager;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\SemaphoreStore;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class TranslatorService implements ServiceInterface
{
    private LockFactory $lockFactory;

    public function __construct(TranslationRepositoryInterface $translationRepository, private readonly TranslationEngineManager $translationEngineManager)
    {
        $store = new SemaphoreStore();
        $this->lockFactory = new LockFactory($store);
    }

    public function getResultFromMessage(Envelope $message): mixed
    {
        return $message->last(HandledStamp::class)->getResult();
    }

    /**
     * @throws \Exception
     */
    public function createTranslation(string $source, string $target, string $text): string
    {
        $lock = $this->lockFactory->createLock($text);

        $attempts = 3;
        while (!$lock->acquire(true, 10) && $attempts > 0) {
            sleep(0.5);
            --$attempts;
        }

        if (0 == $attempts) {
            return new LockedResponse();
        }

        return $this->translationEngineManager->translate($source, $target, $text);
    }

    public function getTranslation(): string
    {
        return 'Translation';
    }

    public function getProviderName(): string
    {
        return $this->translationEngineManager->getProviderName();
    }
}

<?php

namespace App\Domain\Models\Normalizer;

use App\Application\Translator\Service\TranslatorService;
use App\Domain\Interface\LanguageRepositoryInterface;
use App\Domain\Models\Translation;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TranslationNormalizer implements NormalizerInterface
{
    private TranslatorService $translatorService;

    public function __construct(TranslatorService $translatorService)
    {
        $this->translatorService = $translatorService;
    }

    /**
     * @inheritDoc
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $languageNormalizer = new LanguageNormalizer();
        return [
            'id' => $object->getId()->getValue(),
            'sourceText' => $object->getSourceText()->getValue(),
            'source' => $languageNormalizer->normalize($object->getSource()),
            'translated' => $object->getTranslated()?->getValue(),
            'language' => $languageNormalizer->normalize($object->getLanguage()),
            'currentProvider' => $this->translatorService->getProviderName() ?? 'No provider found'
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization(mixed $data, string $format = null)
    {
        return $data instanceof Translation;
    }
}
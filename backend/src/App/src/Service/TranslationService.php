<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\TranslationAdapterInterface;
use App\Adapter\TranslationAdaptersCollection;
use App\Enum\Language;
use App\Exception\TranslationException;

use function array_find;

class TranslationService
{
    public function __construct(
        private readonly TranslationAdaptersCollection $translationAdaptersCollection,
    ) {
    }

    /**
     * @throws TranslationException
     */
    public function translate(
        ?Language $sourceLanguage,
        Language $targetLanguage,
        string $input,
    ): string {
        $sourceLanguage = $sourceLanguage ?: Language::recognize($input);
        $adapter = $this->getAdapter($sourceLanguage, $targetLanguage);

        return $adapter->translate($input);
    }

    public function canTranslate(Language $sourceLanguage, Language $targetLanguage): bool
    {
        try {
            $this->getAdapter($sourceLanguage, $targetLanguage);
            return true;
        } catch (TranslationException) {
            return false;
        }
    }

    /**
     * @throws TranslationException
     */
    public function getAdapter(Language $sourceLanguage, Language $targetLanguage): TranslationAdapterInterface
    {
        /** @var TranslationAdapterInterface $adapter */
        $adapter = array_find(
            $this->translationAdaptersCollection->translationAdapters,
            function (TranslationAdapterInterface $adapter) use (
                $sourceLanguage,
                $targetLanguage,
            ): bool {
                return $adapter->getSourceLanguage() === $sourceLanguage
                    && $adapter->getTargetLanguage() === $targetLanguage;
            },
        );

        if ($adapter === null) {
            throw TranslationException::becauseCannotTranslateFromOrToThisLanguage($sourceLanguage, $targetLanguage);
        }

        return $adapter;
    }
}

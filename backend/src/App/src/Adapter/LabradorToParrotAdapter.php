<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Adapter\TranslationAdapterInterface;
use App\Enum\Language;
use App\Service\TextService;

class LabradorToParrotAdapter implements TranslationAdapterInterface
{
    public function getSourceLanguage(): Language
    {
        return Language::LABRADOR;
    }

    public function getTargetLanguage(): Language
    {
        return Language::PARROT;
    }

    public function translate(string $input): string
    {
        return TextService::prependSentences($input, Language::PARROT_TEXT);
    }
}

<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Adapter\TranslationAdapterInterface;
use App\Enum\Language;
use App\Service\TextService;

class LabradorToPoodleAdapter implements TranslationAdapterInterface
{
    public function getSourceLanguage(): Language
    {
        return Language::LABRADOR;
    }

    public function getTargetLanguage(): Language
    {
        return Language::POODLE;
    }

    public function translate(string $input): string
    {
        return TextService::replaceAllWordsInText($input, 'woefie');
    }
}

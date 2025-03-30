<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Adapter\TranslationAdapterInterface;
use App\Enum\Language;
use App\Service\TextService;

class PoodleToLabradorAdapter implements TranslationAdapterInterface
{
    public function getSourceLanguage(): Language
    {
        return Language::POODLE;
    }

    public function getTargetLanguage(): Language
    {
        return Language::LABRADOR;
    }

    public function translate(string $input): string
    {
        return TextService::replaceAllWordsInText($input, 'woef');
    }
}

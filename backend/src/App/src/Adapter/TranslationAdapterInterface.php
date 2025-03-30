<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Enum\Language;
use App\Exception\TranslationException;

interface TranslationAdapterInterface
{
    /**
     * Returns the source language for which this adapter can translate.
     */
    public function getSourceLanguage(): Language;

    /**
     * Returns the target language for which this adapter can translate.
     */
    public function getTargetLanguage(): Language;

    /**
     * Translates the specified text.
     *
     * @throws TranslationException
     */
    public function translate(string $input): string;
}

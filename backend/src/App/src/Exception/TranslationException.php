<?php

declare(strict_types=1);

namespace App\Exception;

use App\Enum\Language;
use Exception;

class TranslationException extends Exception
{
    public static function becauseCannotTranslateFromOrToThisLanguage(
        ?Language $sourceLanguage,
        Language $targetLanguage,
    ): self {
        return new self(
            message: sprintf(
                'Unable to process translation request, because we can\'t translate from "%s" to "%s".',
                $sourceLanguage?->value ?: 'auto',
                $targetLanguage->value,
            ),
        );
    }

    public static function becauseInputStringIsNotValid(
        Language $sourceLanguage,
        string $input,
    ): self {
        return new self(
            message: sprintf(
                "Unable to process translation request, because the input does not match the specified source"
                . "language. For language '%s', this is not valid text: %s",
                $sourceLanguage->value,
                $input,
            ),
        );
    }
}

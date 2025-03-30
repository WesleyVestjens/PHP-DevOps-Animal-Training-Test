<?php

declare(strict_types=1);

namespace App\Validator;

use App\Enum\Language;
use Laminas\Validator\AbstractValidator;

use function is_string;

class SourceLanguageValidator extends AbstractValidator
{
    public const string INVALID_SOURCE_LANGUAGE = 'invalidSourceLanguage';

    /** @var array<string, string> */
    protected $messageTemplates = [
        self::INVALID_SOURCE_LANGUAGE => 'The value "%value%" is not a valid source language',
    ];

    public function isValid(mixed $value): bool
    {
        if (
            $value === 'auto'
            || $value instanceof Language
            || (is_string($value) && Language::tryFrom($value) !== null)
        ) {
            return true;
        }

        $this->error(self::INVALID_SOURCE_LANGUAGE, $value);
        return false;
    }
}

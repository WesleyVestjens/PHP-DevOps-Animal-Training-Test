<?php

declare(strict_types=1);

namespace App\Enum;

use function current;
use function ksort;
use function str_contains;
use function strtr;
use function trim;

use const SORT_NATURAL;

enum Language: string
{
    case HUMAN    = 'human';
    case LABRADOR = 'labrador';
    case POODLE   = 'poodle';
    case PARROT   = 'parrot';
    case PARAKEET = 'parakeet';

    /**
     * This is the text that is echoed by the parrot.
     */
    public const string PARROT_TEXT = 'Ik praat je na: ';

    /**
     * Common punctuation that can be used in strings.
     */
    private const array STRING_TRANSLATE_PUNCTUATION = [
        ',' => '',
        '.' => '',
        ';' => '',
        ':' => '',
        '!' => '',
        '?' => '',
    ];

    /**
     * The order is used to decide which language/adapter takes precedent for technical reasons.
     * E.g. some languages need to take precedence because they recognize based on longer words.
     */
    public function getOrder(): int
    {
        return match ($this) {
            self::POODLE   => 1,
            self::LABRADOR => 2,
            self::PARROT   => 3,
            self::PARAKEET => 4,
            self::HUMAN    => 5,
        };
    }

    /**
     * This method validates if the given $input matches the Language
     */
    public function validate(string $input): bool
    {
        return match ($this) {
            self::POODLE   => $this->validatePoodle($input),
            self::LABRADOR => $this->validateLabrador($input),
            self::PARROT   => $this->validateParrot($input),
            self::PARAKEET => $this->validateParakeet($input),

            // For human text, we have no practical way for validation.
            self::HUMAN    => true,
        };
    }

    private function validatePoodle(string $input): bool
    {
        return empty(trim(strtr(strtolower($input), ['woefie' => '', ...self::STRING_TRANSLATE_PUNCTUATION])));
    }

    private function validateLabrador(string $input): bool
    {
        return empty(trim(strtr(strtolower($input), ['woef' => '', ...self::STRING_TRANSLATE_PUNCTUATION])));
    }

    private function validateParrot(string $input): bool
    {
        return str_contains(haystack: strtolower($input), needle: strtolower(self::PARROT_TEXT));
    }

    private function validateParakeet(string $input): bool
    {
        return empty(trim(strtr(strtolower($input), ['tjilp' => '', 'piep' => '', ...self::STRING_TRANSLATE_PUNCTUATION])));
    }

    /**
     * This method attempts to recognize the language based on the contents.
     *
     * Human is for all practical purposes always the fallback value, because at the moment there is no reliable way
     * to decide that a text is human.
     */
    public static function recognize(string $input): Language
    {
        /** @var Language[] $matches */
        $matches = [];

        // Conditionals for matches
        $isPossiblePoodleMatch   = str_contains(haystack: $input, needle: 'woefie');
        $isPossibleLabradorMatch = str_contains(haystack: $input, needle: 'woef');
        $isPossibleParrotMatch   = str_contains(haystack: $input, needle: self::PARROT_TEXT);
        $isPossibleParakeetMatch = str_contains(haystack: $input, needle: 'tjlip')
            || str_contains(haystack: $input, needle: 'piep');

        // Add matches to array
        if ($isPossibleLabradorMatch && self::LABRADOR->validate($input)) {
            $matches[self::LABRADOR->getOrder()] = self::LABRADOR;
        }

        if ($isPossiblePoodleMatch && self::POODLE->validate($input)) {
            $matches[self::POODLE->getOrder()] = self::POODLE;
        }

        if ($isPossibleParrotMatch && self::PARROT->validate($input)) {
            $matches[self::PARROT->getOrder()] = self::PARROT;
        }

        if ($isPossibleParakeetMatch && self::PARAKEET->validate($input)) {
            $matches[self::PARAKEET->getOrder()] = self::PARAKEET;
        }

        // Human practically always matches, because we have nothing to validate on...
        $matches[self::HUMAN->getOrder()] = self::HUMAN;

        // Sort them by their order: this ensures that `woefie` takes precedence over `woef`, because PHP can't
        //differentiate between the two without more advanced lexical parsing.
        ksort($matches, SORT_NATURAL);

        return current($matches);
    }
}

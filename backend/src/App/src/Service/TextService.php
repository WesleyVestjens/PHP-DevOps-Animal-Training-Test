<?php

declare(strict_types=1);

namespace App\Service;

use function array_map;
use function current;
use function implode;
use function in_array;
use function mb_strtolower;
use function mb_substr;
use function preg_replace_callback;
use function preg_split;
use function trim;

use const PREG_SPLIT_NO_EMPTY;

class TextService
{
    public static function prependSentences(
        string $input,
        string $prependText,
    ): string {
        return implode(
            separator: ' ',
            array: array_map(
                fn(string $sentence): string => $prependText . trim($sentence),
                self::splitToSentences($input),
            ),
        );
    }

    /**
     * Shamelessly borrowed from:
     *
     * @see https://stackoverflow.com/questions/10494176/explode-a-paragraph-into-sentences-in-php
     *
     * @return string[]
     */
    public static function splitToSentences(string $input): array
    {
        return preg_split('/(?<=[.?!;:])\s+/', $input, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Replace all words in a text with a specific word, preserving what we can.
     *
     * The regex matches full words, treating Unicode characters as words.
     * If the $vowelReplaceWord is not null, then we use it to replace the relevant words.
     */
    public static function replaceAllWordsInText(
        string $input,
        string $replaceWord,
        ?string $vowelReplaceWord = null,
    ): string {
        $result = preg_replace_callback(
            '/\w+/u',
            function ($match) use ($replaceWord, $vowelReplaceWord) {
                if ($vowelReplaceWord === null) {
                    return $replaceWord;
                }

                $word           = current($match);
                $firstChar      = mb_substr($word, 0, 1);
                $firstCharLower = mb_strtolower($firstChar);
                $vowels         = ['a', 'e', 'i', 'o', 'u'];

                return in_array($firstCharLower, $vowels) ? $vowelReplaceWord : $replaceWord;
            },
            $input,
        );

        return $result ?? '';
    }
}

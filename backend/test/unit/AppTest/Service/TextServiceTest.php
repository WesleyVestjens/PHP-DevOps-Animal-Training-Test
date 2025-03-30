<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Service\TextService;
use PHPUnit\Framework\TestCase;

class TextServiceTest extends TestCase
{
    public function testPrependSentences(): void
    {
        // When
        $prependedSentences = TextService::prependSentences(
            'This is some paragraph. With multiple lines. Yes three of them',
            'Sentence: ',
        );

        // Then
        $this->assertSame(
            expected: 'Sentence: This is some paragraph. Sentence: With multiple lines. Sentence: Yes three of them',
            actual: $prependedSentences,
        );
    }

    public function testSplitToSentences(): void
    {
        // When
        $prependedSentences = TextService::splitToSentences(
            'This is some paragraph. With multiple lines. Yes three of them',
        );

        // Then
        $this->assertSame(
            expected: [
                'This is some paragraph.',
                'With multiple lines.',
                'Yes three of them',
            ],
            actual: $prependedSentences,
        );
    }

    public function testReplaceAllWordsWithoutAVowelWord(): void
    {
        // When
        $replacedWords = TextService::replaceAllWordsInText(
            'I have four words.',
            'Word',
        );

        // Then
        $this->assertSame(
            expected: 'Word Word Word Word.',
            actual: $replacedWords,
        );
    }

    public function testReplaceAllWordsWithAVowelWord(): void
    {
        // When
        $replacedWords = TextService::replaceAllWordsInText(
            'Alpha Bravo Charlie Delta Echo',
            'Consonant',
            'Vowel',
        );

        // Then
        $this->assertSame(
            expected: 'Vowel Consonant Consonant Consonant Vowel',
            actual: $replacedWords,
        );
    }
}

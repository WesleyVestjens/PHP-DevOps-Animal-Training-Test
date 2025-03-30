<?php

declare(strict_types=1);

namespace AppTest\Enum;

use App\Enum\Language;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    public function testCanCreateEnum(): void
    {
        $this->assertInstanceOf(Language::class, Language::PARROT);
    }

    public function testWhenGetOrderIsCalledThenTheCorrectOrderIsUsed(): void
    {
        // Then
        $this->assertSame(1, Language::POODLE->getOrder());
        $this->assertSame(2, Language::LABRADOR->getOrder());
        $this->assertSame(3, Language::PARROT->getOrder());
        $this->assertSame(4, Language::PARAKEET->getOrder());
        $this->assertSame(5, Language::HUMAN->getOrder());
    }

    #[DataProvider('dataProviderValidateMethod')]
    public function testGivenInputWhenValidateIsCalledThenTheExpectedResultIsReturned(
        string $input,
        Language $enum,
        bool $expectedResult,
    ): void {
        // Given $input & $enum

        // When
        $result = $enum->validate($input);

        // Then
        $this->assertSame(expected: $expectedResult, actual: $result);
    }

    public static function dataProviderValidateMethod(): array
    {
        return [
            'human' => [
                'This is some human text.',
                Language::HUMAN,
                true,
            ],
            'poodle-valid' => [
                'woefie woefie woefie!!',
                Language::POODLE,
                true,
            ],
            'poodle-invalid' => [
                'woefie woefie woef!',
                Language::POODLE,
                false,
            ],
            'labrador-valid' => [
                'woef woef woef!!',
                Language::LABRADOR,
                true,
            ],
            'labrador-invalid' => [
                'miaw woeff!',
                Language::LABRADOR,
                false,
            ],
            'parrot-valid' => [
                'Ik praat je na: Foobar. Ik praat je na: Hello there',
                Language::PARROT,
                true,
            ],
            'parrot-invalid' => [
                'Foobar. Hello there.',
                Language::PARROT,
                false,
            ],
            'parakeet-valid' => [
                'Tjilp tjilp, tjilp. Piep piep piep PIEP!',
                Language::PARAKEET,
                true,
            ],
            'parakeet-invalid' => [
                'Hello I am a parakeet.',
                Language::PARAKEET,
                false,
            ],
        ];
    }

    #[DataProvider('dataProviderRecognizeLanguages')]
    public function testWhenRecognizeIsCalledThenTheCorrectLanguageIsReturned(
        string $input,
        Language $expectedLanguage,
    ): void {
        // When
        $recognizedLanguage = Language::recognize($input);

        // Then
        $this->assertSame(expected: $expectedLanguage, actual: $recognizedLanguage);
    }

    public static function dataProviderRecognizeLanguages(): array
    {
        return [
            'human' => [
                'This is human text.',
                Language::HUMAN,
            ],
            'labrador' => [
                'Woef woef woef, woef!',
                Language::LABRADOR,
            ],
            'poodle' => [
                'Woefie woefie, woefie!',
                Language::POODLE,
            ],
            'parakeet' => [
                'Tjilp, tjilp, tjilp, piep, piep PIEP!',
                Language::PARAKEET,
            ],
            'parrot' => [
                'Ik praat je na: Do something',
                Language::PARROT,
            ],
        ];
    }
}

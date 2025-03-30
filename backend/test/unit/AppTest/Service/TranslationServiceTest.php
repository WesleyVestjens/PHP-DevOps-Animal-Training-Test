<?php

declare(strict_types=1);

namespace AppTest\Service;

use App\Adapter\TranslationAdapterInterface;
use App\Adapter\TranslationAdaptersCollection;
use App\Enum\Language;
use App\Service\TranslationService;
use AppTest\Adapter\TranslationAdapterFixture;
use PHPUnit\Framework\TestCase;

class TranslationServiceTest extends TestCase
{
    private readonly TranslationAdaptersCollection $translationAdaptersCollection;
    private readonly TranslationService $service;

    private readonly TranslationAdapterInterface $mockAdapterHumanToParrot;

    protected function setUp(): void
    {
        $this->mockAdapterHumanToParrot = TranslationAdapterFixture::create(
            Language::HUMAN,
            Language::PARROT,
        );
        $this->translationAdaptersCollection = new TranslationAdaptersCollection(
            [
                $this->mockAdapterHumanToParrot,
            ],
        );
        $this->service = new TranslationService(
            translationAdaptersCollection: $this->translationAdaptersCollection,
        );
    }

    public function testCanCreateTranslationService(): void
    {
        $this->assertInstanceOf(TranslationService::class, $this->service);
    }

    public function testGivenNullSourceLanguageWhenTranslateIsCalledThenRecognizeLanguage(): void
    {
        // Given
        $this->mockAdapterHumanToParrot->expects('translate')->with('Translate me.')
            ->andReturn('Ik praat je na: Translate me.');

        // When
        $result = $this->service->translate(
            null,
            Language::PARROT,
            'Translate me.',
        );

        // Then
        $this->assertSame('Ik praat je na: Translate me.', $result);
    }

    public function testGivenAdapterExistsWhenCanTranslateIsCalledThenItReturnsTrue(): void
    {
        // When
        $result = $this->service->canTranslate(Language::HUMAN, Language::PARROT);

        // Then
        $this->assertTrue($result);
    }

    public function testGivenAdapterDoesNotExistsWhenCanTranslateIsCalledThenItReturnsFalse(): void
    {
        // When
        $result = $this->service->canTranslate(Language::HUMAN, Language::PARAKEET);

        // Then
        $this->assertFalse($result);
    }
}

<?php

declare(strict_types=1);

namespace AppTest\Validator;

use App\Enum\Language;
use App\Validator\SourceLanguageValidator;
use PHPUnit\Framework\TestCase;

class SourceLanguageValidatorTest extends TestCase
{
    private SourceLanguageValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new SourceLanguageValidator();
    }

    public function testCanCreateValidator(): void
    {
        $this->assertInstanceOf(SourceLanguageValidator::class, $this->validator);
    }

    public function testWhenValueIsValidThenReturnsTrue(): void
    {
        // When
        $result = $this->validator->isValid(Language::HUMAN);

        // Then
        $this->assertTrue($result);
    }

    public function testWhenValueIsInvalidThenIsValidReturnsFalse(): void
    {
        // Given
        $value = 'I am not a valid enum value.';

        // When
        $result = $this->validator->isValid($value);

        // Then
        $this->assertFalse($result);
        $this->assertCount(1, $this->validator->getMessages());
        $this->assertArrayHasKey(SourceLanguageValidator::INVALID_SOURCE_LANGUAGE, $this->validator->getMessages());
    }
}

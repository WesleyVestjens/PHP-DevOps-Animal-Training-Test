<?php

declare(strict_types=1);

namespace AppTest\Validator;

use App\Validator\EnumValidator;
use AppTest\Enum\SomeFirstEnum;
use AppTest\Enum\SomeOtherEnum;
use Laminas\Validator\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

class EnumValidatorTest extends TestCase
{
    private EnumValidator $enumValidator;

    protected function setUp(): void
    {
        $this->enumValidator = new EnumValidator();
    }

    public function testItCanCreate(): void
    {
        $this->assertInstanceOf(EnumValidator::class, $this->enumValidator);
    }

    public function testWhenValueIsNullThenIsValidReturnsFalse(): void
    {
        // Given
        $this->enumValidator->setEnum(SomeFirstEnum::class);
        $value = null;

        // When
        $result = $this->enumValidator->isValid($value);

        // Then
        $this->assertFalse($result);
        $this->assertCount(1, $this->enumValidator->getMessages());
        $this->assertArrayHasKey(EnumValidator::NOT_IN_ENUM, $this->enumValidator->getMessages());
    }

    public function testWhenValueIsAStringEnumThenIsValidReturnsFalse(): void
    {
        // Given
        $this->enumValidator->setEnum(SomeFirstEnum::class);
        $value = 'whatsapp_meta';

        // When
        $result = $this->enumValidator->isValid($value);

        // Then
        $this->assertFalse($result);
        $this->assertCount(1, $this->enumValidator->getMessages());
        $this->assertArrayHasKey(EnumValidator::NOT_IN_ENUM, $this->enumValidator->getMessages());
    }

    public function testWhenValueIsADifferentEnumThenIsValidReturnsFalse(): void
    {
        // Given
        $this->enumValidator->setEnum(SomeFirstEnum::class);
        $value = SomeOtherEnum::FOO;

        // When
        $result = $this->enumValidator->isValid($value);

        // Then
        $this->assertFalse($result);
        $this->assertCount(1, $this->enumValidator->getMessages());
        $this->assertArrayHasKey(EnumValidator::NOT_IN_ENUM, $this->enumValidator->getMessages());
    }

    public function testWhenValueIsCorrectEnumThenIsValidReturnsTrue(): void
    {
        // Given
        $this->enumValidator->setEnum(SomeFirstEnum::class);
        $value = SomeFirstEnum::FOO;

        // When
        $result = $this->enumValidator->isValid($value);

        // Then
        $this->assertTrue($result);
    }

    public function testWhenEnumIsNotSetValidatorThrowsException(): void
    {
        // Given
        $value = SomeFirstEnum::FOO;

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('enum option is mandatory');

        // When
        $result = $this->enumValidator->isValid($value);
    }
}

<?php

declare(strict_types=1);

namespace App\Validator;

use Laminas\Validator\AbstractValidator;
use Laminas\Validator\Exception\RuntimeException;

class EnumValidator extends AbstractValidator
{
    public const string NOT_IN_ENUM = 'notInEnum';

    /** @var array<string, string> */
    protected $messageTemplates = [
        self::NOT_IN_ENUM => 'The value "%value%" is not a valid enum value',
    ];

    /**
     * Enum class to validate against
     */
    protected ?string $enumClass = null;

    public function isValid(mixed $value): bool
    {
        $enum = $this->getEnum();
        if (! $value instanceof $enum) {
            $this->error(self::NOT_IN_ENUM, $value);
            return false;
        }
        return true;
    }

    public function setEnum(string $enumClass): void
    {
        $this->enumClass = $enumClass;
    }

    public function getEnum(): string
    {
        if ($this->enumClass === null) {
            throw new RuntimeException('enum option is mandatory');
        }
        return $this->enumClass;
    }
}

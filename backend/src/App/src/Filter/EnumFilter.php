<?php

declare(strict_types=1);

namespace App\Filter;

use BackedEnum;
use Laminas\Filter\Exception\RuntimeException;
use Laminas\Filter\FilterInterface;

use function array_key_exists;
use function is_array;
use function is_string;

class EnumFilter implements FilterInterface
{
    protected mixed $enum;

    public function __construct(?array $options = null)
    {
        if (!(is_array($options) && array_key_exists('enum', $options))) {
            throw new RuntimeException('Options should have a key called enum');
        }
        $this->enum = $options['enum'];
    }

    public function filter(mixed $value): BackedEnum | null | string
    {
        return $this->enum::tryFrom($value ?? '')
            ?? ($value instanceof BackedEnum || $value === null || is_string($value) ? $value : null);
    }
}

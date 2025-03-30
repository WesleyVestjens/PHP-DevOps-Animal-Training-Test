<?php

declare(strict_types=1);

namespace AppTest;

class AutoFixture
{
    public static function number(int $max = 100, int $min = 1): int
    {
        return random_int($min, $max);
    }

    public static function bigint(int $times = 20): string
    {
        $numbers = [];
        $times = max(min($times, 50), 0);

        for ($i = 0; $i < $times; $i++) {
            $numbers[] = self::number(9, 0);
        }

        return implode('', $numbers);
    }

    public static function string(int $length = 5, string $prefix = ''): string
    {
        $result = '';

        $characters = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
        $charactersLength = count($characters);

        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $charactersLength - 1)];
        }

        if (strlen($prefix) > 0) {
            return sprintf('[%s]:%s', $prefix, $result);
        }

        return $result;
    }

    public static function email(?string $domain): string
    {
        return sprintf('%s@%s.nl', self::string(), $domain ?? self::string());
    }

    public static function boolean(): bool
    {
        return self::pickOne(true, false);
    }

    public static function pickOne(mixed ...$items): mixed
    {
        $length = count($items);

        $pick = random_int(0, $length - 1);

        return $items[$pick];
    }
}

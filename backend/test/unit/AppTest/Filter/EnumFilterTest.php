<?php

declare(strict_types=1);

namespace AppTest\Filter;

use App\Enum\Language;
use App\Filter\EnumFilter;
use Laminas\Filter\Exception\RuntimeException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class EnumFilterTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testConstruct(): void
    {
        // When
        $result = new EnumFilter([
            'enum' => Language::class,
        ]);

        // Then
        $this->assertInstanceOf(EnumFilter::class, $result);
    }

    public function testConstructWithIncorrectOptions(): void
    {
        // Then
        $this->expectException(RuntimeException::class);

        // When
        new EnumFilter([
            'bla' => Language::class,
        ]);
    }

    public function testFilter(): void
    {
        // Given
        $filter = new EnumFilter([
            'enum' => Language::class,
        ]);

        // When
        $result = $filter->filter('human');

        // Then
        $this->assertInstanceOf(Language::class, $result);
    }
}

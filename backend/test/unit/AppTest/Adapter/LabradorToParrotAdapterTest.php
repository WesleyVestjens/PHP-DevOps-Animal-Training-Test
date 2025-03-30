<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\LabradorToParrotAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class LabradorToParrotAdapterTest extends TestCase
{
    private readonly LabradorToParrotAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new LabradorToParrotAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::LABRADOR, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::PARROT, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'Ik praat je na: woef woef',
            $this->adapter->translate('woef woef'),
        );
    }
}

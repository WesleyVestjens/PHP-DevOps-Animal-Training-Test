<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\ParakeetToParrotAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class ParakeetToParrotAdapterTest extends TestCase
{
    private readonly ParakeetToParrotAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new ParakeetToParrotAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::PARAKEET, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::PARROT, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'Ik praat je na: tjilp piep',
            $this->adapter->translate('tjilp piep'),
        );
    }
}

<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\HumanToParrotAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class HumanToParrotAdapterTest extends TestCase
{
    private readonly HumanToParrotAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new HumanToParrotAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::HUMAN, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::PARROT, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'Ik praat je na: text text',
            $this->adapter->translate('text text'),
        );
    }
}

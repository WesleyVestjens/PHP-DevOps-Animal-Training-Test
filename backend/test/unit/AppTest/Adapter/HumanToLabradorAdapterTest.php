<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\HumanToLabradorAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class HumanToLabradorAdapterTest extends TestCase
{
    private readonly HumanToLabradorAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new HumanToLabradorAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::HUMAN, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::LABRADOR, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'woef woef',
            $this->adapter->translate('text text'),
        );
    }
}

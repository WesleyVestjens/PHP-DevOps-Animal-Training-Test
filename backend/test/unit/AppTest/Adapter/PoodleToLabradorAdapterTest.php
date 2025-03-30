<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\PoodleToLabradorAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class PoodleToLabradorAdapterTest extends TestCase
{
    private readonly PoodleToLabradorAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new PoodleToLabradorAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::POODLE, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::LABRADOR, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'woef woef',
            $this->adapter->translate('text text'),
        );
    }
}

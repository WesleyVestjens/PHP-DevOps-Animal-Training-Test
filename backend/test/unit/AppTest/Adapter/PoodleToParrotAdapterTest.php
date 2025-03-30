<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\PoodleToParrotAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class PoodleToParrotAdapterTest extends TestCase
{
    private readonly PoodleToParrotAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new PoodleToParrotAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::POODLE, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::PARROT, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'Ik praat je na: text text',
            $this->adapter->translate('text text'),
        );
    }
}

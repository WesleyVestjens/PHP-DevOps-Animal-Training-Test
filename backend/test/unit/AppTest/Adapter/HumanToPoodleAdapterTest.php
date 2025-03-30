<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\HumanToPoodleAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class HumanToPoodleAdapterTest extends TestCase
{
    private readonly HumanToPoodleAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new HumanToPoodleAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::HUMAN, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::POODLE, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'woefie woefie',
            $this->adapter->translate('text text'),
        );
    }
}

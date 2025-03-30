<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\LabradorToPoodleAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class LabradorToPoodleAdapterTest extends TestCase
{
    private readonly LabradorToPoodleAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new LabradorToPoodleAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::LABRADOR, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::POODLE, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'woefie woefie',
            $this->adapter->translate('text text'),
        );
    }
}

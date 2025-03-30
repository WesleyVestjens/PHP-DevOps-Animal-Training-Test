<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\HumanToParakeetAdapter;
use App\Enum\Language;
use PHPUnit\Framework\TestCase;

class HumanToParakeetAdapterTest extends TestCase
{
    private readonly HumanToParakeetAdapter $adapter;

    protected function setUp(): void
    {
        $this->adapter = new HumanToParakeetAdapter();
    }

    public function testAdapter(): void
    {
        $this->assertSame(Language::HUMAN, $this->adapter->getSourceLanguage());
        $this->assertSame(Language::PARAKEET, $this->adapter->getTargetLanguage());
        $this->assertSame(
            'tjilp piep',
            $this->adapter->translate('alpha charlie'),
        );
    }
}

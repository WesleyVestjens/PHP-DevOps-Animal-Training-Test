<?php

declare(strict_types=1);

namespace AppTest\Adapter;

use App\Adapter\TranslationAdapterInterface;
use App\Enum\Language;
use AppTest\AutoFixture;
use Mockery;
use Mockery\MockInterface;

class TranslationAdapterFixture
{
    public static function create(
        ?Language $sourceLanguage = null,
        ?Language $targetLanguage = null,
    ): TranslationAdapterInterface|MockInterface {
        $adapter = Mockery::mock(TranslationAdapterInterface::class);

        $adapter->expects('getSourceLanguage')->zeroOrMoreTimes()
            ->andReturn($sourceLanguage);

        $adapter->expects('getTargetLanguage')->zeroOrMoreTimes()
            ->andReturn($targetLanguage ?? AutoFixture::pickOne(Language::cases()));

        // translate is not mocked here on purpose; you should expect this yourself to ensure proper behavior.

        return $adapter;
    }
}

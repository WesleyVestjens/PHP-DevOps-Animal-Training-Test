<?php

declare(strict_types=1);

namespace AppTest\Adapter\Factory;

use App\Adapter\Factory\TranslationAdaptersCollectionFactory;
use App\Adapter\TranslationAdaptersCollection;
use AppTest\Adapter\TranslationAdapterFixture;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class TranslationAdaptersCollectionFactoryTest extends TestCase
{
    public function testWhenConfigIsEmptyThenCanCreateTranslationAdaptersCollection(): void
    {
        // Given
        $container = Mockery::mock(ContainerInterface::class);
        $container->expects('get')->with('config')
            ->andReturn([]);

        // When
        $factory = new TranslationAdaptersCollectionFactory();
        $instance = $factory($container, TranslationAdaptersCollection::class, []);

        // Then
        $this->assertInstanceOf(TranslationAdaptersCollection::class, $instance);
    }

    public function testWhenConfigHasAdaptersThenCanCreateTranslationAdaptersCollection()
    {
        // Given
        $mockAdapter = TranslationAdapterFixture::create();

        $container = Mockery::mock(ContainerInterface::class);
        $container->expects('get')->with('config')
            ->andReturn([
                'translation-adapters' => [$mockAdapter::class],
            ]);

        $container->expects('get')->with($mockAdapter::class)->andReturn($mockAdapter);

        // When
        $factory = new TranslationAdaptersCollectionFactory();
        $instance = $factory($container, TranslationAdaptersCollection::class, []);

        // Then
        $this->assertInstanceOf(TranslationAdaptersCollection::class, $instance);
    }
}

<?php

declare(strict_types=1);

namespace AppTest\Service\Factory;

use App\Adapter\TranslationAdaptersCollection;
use App\Service\Factory\TranslationServiceFactory;
use App\Service\TranslationService;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class TranslationServiceFactoryTest extends TestCase
{
    public function testCanCreateService(): void
    {
        // Given
        $container = Mockery::mock(ContainerInterface::class);
        $container->expects('get')->with(TranslationAdaptersCollection::class)
            ->andReturn(new TranslationAdaptersCollection([]));

        // When
        $factory = new TranslationServiceFactory();
        $instance = $factory($container, TranslationService::class, []);

        // Then
        $this->assertInstanceOf(TranslationService::class, $instance);
    }
}

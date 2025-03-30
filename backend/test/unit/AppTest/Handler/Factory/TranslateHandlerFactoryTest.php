<?php

declare(strict_types=1);

namespace AppTest\Handler\Factory;

use App\Handler\Factory\TranslateHandlerFactory;
use App\Handler\TranslateHandler;
use App\InputFilter\TranslateInputFilter;
use App\Service\TranslationService;
use Laminas\InputFilter\InputFilterPluginManager;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class TranslateHandlerFactoryTest extends TestCase
{
    public function testCanCreateHandler(): void
    {
        // Given
        $inputFilterPluginManager = Mockery::mock(InputFilterPluginManager::class);
        $inputFilterPluginManager->expects('get')->with(TranslateInputFilter::class)
            ->andReturn(Mockery::mock(TranslateInputFilter::class));

        $container = Mockery::mock(ContainerInterface::class);
        $container->expects('get')->with(InputFilterPluginManager::class)
            ->andReturn($inputFilterPluginManager);
        $container->expects('get')->with(TranslationService::class)
            ->andReturn(Mockery::mock(TranslationService::class));

        // When
        $factory = new TranslateHandlerFactory();
        $instance = $factory($container, TranslateHandler::class, []);

        // Then
        $this->assertInstanceOf(TranslateHandler::class, $instance);
    }
}

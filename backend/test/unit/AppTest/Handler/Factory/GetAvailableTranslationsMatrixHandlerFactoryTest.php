<?php

declare(strict_types=1);

namespace AppTest\Handler\Factory;

use App\Handler\Factory\GetAvailableTranslationsMatrixHandlerFactory;
use App\Handler\GetAvailableTranslationsMatrixHandler;
use App\Service\TranslationService;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class GetAvailableTranslationsMatrixHandlerFactoryTest extends TestCase
{
    public function testCanCreateHandler(): void
    {
        // Given
        $container = Mockery::mock(ContainerInterface::class);
        $container->expects('get')->with(TranslationService::class)
            ->andReturn(Mockery::mock(TranslationService::class));

        // When
        $factory = new GetAvailableTranslationsMatrixHandlerFactory();
        $instance = $factory($container, GetAvailableTranslationsMatrixHandler::class, []);

        // Then
        $this->assertInstanceOf(GetAvailableTranslationsMatrixHandler::class, $instance);
    }
}

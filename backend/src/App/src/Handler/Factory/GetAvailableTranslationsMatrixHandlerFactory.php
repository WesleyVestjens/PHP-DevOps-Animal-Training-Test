<?php

declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\GetAvailableTranslationsMatrixHandler;
use App\Service\TranslationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final readonly class GetAvailableTranslationsMatrixHandlerFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $container,
        mixed $requestedName,
        ?array $options = null,
    ): GetAvailableTranslationsMatrixHandler {
        return new GetAvailableTranslationsMatrixHandler(
            translationService: $container->get(TranslationService::class),
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Factory;

use App\Adapter\TranslationAdaptersCollection;
use App\Service\TranslationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final readonly class TranslationServiceFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, mixed $requestedName, ?array $options = null): TranslationService
    {
        $adapterCollection = $container->get(TranslationAdaptersCollection::class);

        return new TranslationService(
            translationAdaptersCollection: $adapterCollection,
        );
    }
}

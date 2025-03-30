<?php

declare(strict_types=1);

namespace App\Adapter\Factory;

use App\Adapter\TranslationAdapterInterface;
use App\Adapter\TranslationAdaptersCollection;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final readonly class TranslationAdaptersCollectionFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, mixed $requestedName, ?array $options = null): TranslationAdaptersCollection
    {
        $config = $container->get('config') ?? [] ?: [];
        /** @var string[] $translationAdaptersConfig */
        $translationAdaptersConfig = $config['translation-adapters'] ?? [];

        return new TranslationAdaptersCollection(
            translationAdapters: array_map(
                function (string $adapterClassName) use ($container): TranslationAdapterInterface {
                    return $container->get($adapterClassName);
                },
                $translationAdaptersConfig,
            ),
        );
    }
}

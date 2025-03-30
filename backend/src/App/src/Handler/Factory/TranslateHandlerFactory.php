<?php

declare(strict_types=1);

namespace App\Handler\Factory;

use App\Handler\TranslateHandler;
use App\InputFilter\TranslateInputFilter;
use App\Service\TranslationService;
use Laminas\InputFilter\InputFilterPluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final readonly class TranslateHandlerFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, mixed $requestedName, ?array $options = null): TranslateHandler
    {
        $translationService = $container->get(TranslationService::class);
        /** @var InputFilterPluginManager $inputFilterPluginManager */
        $inputFilterPluginManager = $container->get(InputFilterPluginManager::class);
        /** @var TranslateInputFilter $translateInputFilter */
        $translateInputFilter = $inputFilterPluginManager->get(TranslateInputFilter::class);

        return new TranslateHandler(
            translationService: $translationService,
            translateInputFilter: $translateInputFilter,
        );
    }
}

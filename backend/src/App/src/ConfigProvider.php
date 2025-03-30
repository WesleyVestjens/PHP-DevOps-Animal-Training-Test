<?php

declare(strict_types=1);

namespace App;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'invokables' => [
                    Adapter\HumanToLabradorAdapter::class,
                    Adapter\HumanToParakeetAdapter::class,
                    Adapter\HumanToParrotAdapter::class,
                    Adapter\HumanToPoodleAdapter::class,
                    Adapter\LabradorToParrotAdapter::class,
                    Adapter\LabradorToPoodleAdapter::class,
                    Adapter\ParakeetToParrotAdapter::class,
                    Adapter\PoodleToLabradorAdapter::class,
                    Adapter\PoodleToParrotAdapter::class,
                    Handler\PingHandler::class,
                    Service\TextService::class,
                ],
                'factories' => [
                    Adapter\TranslationAdaptersCollection::class => Adapter\Factory\TranslationAdaptersCollectionFactory::class,
                    Handler\GetAvailableTranslationsMatrixHandler::class => Handler\Factory\GetAvailableTranslationsMatrixHandlerFactory::class,
                    Handler\TranslateHandler::class => Handler\Factory\TranslateHandlerFactory::class,
                    Service\TranslationService::class => Service\Factory\TranslationServiceFactory::class,
                ],
            ],
            'translation-adapters' => [
                Adapter\HumanToLabradorAdapter::class,
                Adapter\HumanToParakeetAdapter::class,
                Adapter\HumanToParrotAdapter::class,
                Adapter\HumanToPoodleAdapter::class,
                Adapter\LabradorToParrotAdapter::class,
                Adapter\LabradorToPoodleAdapter::class,
                Adapter\ParakeetToParrotAdapter::class,
                Adapter\PoodleToLabradorAdapter::class,
                Adapter\PoodleToParrotAdapter::class,
            ],
        ];
    }
}

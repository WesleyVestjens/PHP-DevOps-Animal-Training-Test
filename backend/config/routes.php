<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\PingHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->get('/api/translation-matrix', App\Handler\GetAvailableTranslationsMatrixHandler::class, 'api.translation-matrix');
    $app->post('/api/translate', App\Handler\TranslateHandler::class, 'api.translate');
};

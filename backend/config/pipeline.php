<?php

declare(strict_types=1);

use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;

/**
 * Setup middleware pipeline:
 */

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    // Error handling first
    $app->pipe(ErrorHandler::class);

    // Core middleware
    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe(RouteMiddleware::class);

    // Security middleware
    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);

    // More core middleware
    $app->pipe(UrlHelperMiddleware::class);

    // Parse body
    $app->pipe(BodyParamsMiddleware::class);

    // Register the dispatch middleware in the middleware pipeline
    $app->pipe(DispatchMiddleware::class);

    // Fallback: if nothing matches, return error
    $app->pipe(NotFoundHandler::class);
};

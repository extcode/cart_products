<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Configuration;

use Extcode\CartProducts\Handler\WatchlistItemHandler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use WerkraumMedia\Watchlist\Domain\ItemHandlerRegistry;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder) {
    if ($containerBuilder->hasDefinition(ItemHandlerRegistry::class)) {
        $watchlistItemHandlerDefinition = new Definition(
            WatchlistItemHandler::class
        );
        $watchlistItemHandlerDefinition->addTag('watchlist.itemHandler')
            ->setAutoconfigured(true)
            ->setAutowired(true);
        $containerBuilder->addDefinitions(
            [
                WatchlistItemHandler::class => $watchlistItemHandlerDefinition,
            ]
        );
    }
};

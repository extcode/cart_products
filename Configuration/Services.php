<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Configuration;

use Extcode\CartProducts\Handler\WatchlistItemHandler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder) {
    if ($containerBuilder->hasDefinition(\WerkraumMedia\Watchlist\Domain\ItemHandlerRegistry::class)) {
        $watchlistItemHandlerDefinition = new \Symfony\Component\DependencyInjection\Definition(
            WatchlistItemHandler::class
        );
        $watchlistItemHandlerDefinition->addTag('watchlist.itemHandler')
            ->setAutoconfigured(true)
            ->setAutowired(true);
        $containerBuilder->addDefinitions([
            WatchlistItemHandler::class => $watchlistItemHandlerDefinition
        ]);
    }
};

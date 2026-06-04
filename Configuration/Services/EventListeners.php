<?php

declare(strict_types=1);

use Extcode\Cart\Event\CheckProductAvailabilityEvent;
use Extcode\Cart\Event\Order\StockEvent;
use Extcode\Cart\Event\ProcessOrderCheckStockEvent;
use Extcode\Cart\Event\RetrieveProductsFromRequestEvent as CartRetrieveProductsFromRequestEvent;
use Extcode\CartProducts\Event\RetrieveProductsFromRequestEvent as CartProductsRetrieveProductsFromRequestEvent;
use Extcode\CartProducts\EventListener\CheckProductAvailability;
use Extcode\CartProducts\EventListener\Create\CheckRequest;
use Extcode\CartProducts\EventListener\Create\CreateCartBackendVariants;
use Extcode\CartProducts\EventListener\Create\CreateCartFrontendVariants;
use Extcode\CartProducts\EventListener\Create\CreateCartProduct;
use Extcode\CartProducts\EventListener\Create\LoadProduct;
use Extcode\CartProducts\EventListener\Order\Stock\CheckStock;
use Extcode\CartProducts\EventListener\Order\Stock\FlushCache;
use Extcode\CartProducts\EventListener\Order\Stock\HandleStock;
use Extcode\CartProducts\EventListener\RetrieveProductsFromRequest;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
    ;

    $services
        ->set(CheckRequest::class)
        ->tag(
            'event.listener',
            [
                'event' => CartProductsRetrieveProductsFromRequestEvent::class,
                'identifier' => 'cart-products--create--check-request',
            ]
        )
    ;

    $services
        ->set(LoadProduct::class)
        ->tag(
            'event.listener',
            [
                'event' => CartProductsRetrieveProductsFromRequestEvent::class,
                'identifier' => 'cart-products--create--load-product',
                'after' => 'cart-products--create--check-request',
            ]
        )
    ;

    $services
        ->set(CreateCartFrontendVariants::class)
        ->tag(
            'event.listener',
            [
                'event' => CartProductsRetrieveProductsFromRequestEvent::class,
                'identifier' => 'cart-products--create--create-cart-frontend-variants',
                'after' => 'cart-products--create--load-product',
            ]
        )
    ;

    $services
        ->set(CreateCartProduct::class)
        ->tag(
            'event.listener',
            [
                'event' => CartProductsRetrieveProductsFromRequestEvent::class,
                'identifier' => 'cart-products--create--create-cart-product',
                'after' => 'cart-products--create--create-cart-frontend-variants',
            ]
        )
    ;

    $services
        ->set(CreateCartBackendVariants::class)
        ->tag(
            'event.listener',
            [
                'event' => CartProductsRetrieveProductsFromRequestEvent::class,
                'identifier' => 'cart-products--create--create-cart-backend-variants',
                'after' => 'cart-products--create--create-cart-product',
            ]
        )
    ;

    $services
        ->set(HandleStock::class)
        ->tag(
            'event.listener',
            [
                'event' => StockEvent::class,
                'identifier' => 'cart-products--order--stock--handle-stock',
            ]
        )
    ;

    $services
        ->set(FlushCache::class)
        ->tag(
            'event.listener',
            [
                'event' => StockEvent::class,
                'identifier' => 'cart-products--order--stock--flush-cache',
                'after' => 'cart-books--order--stock--handle-stock',
            ]
        )
    ;

    $services
        ->set(RetrieveProductsFromRequest::class)
        ->tag(
            'event.listener',
            [
                'event' => CartRetrieveProductsFromRequestEvent::class,
                'identifier' => 'cart-products--retrieve-products-from-request',
            ]
        )
    ;

    $services
        ->set(CheckProductAvailability::class)
        ->tag(
            'event.listener',
            [
                'event' => CheckProductAvailabilityEvent::class,
                'identifier' => 'cart-products--check-product-availability',
            ]
        )
    ;

    $services
        ->set(CheckStock::class)
        ->tag(
            'event.listener',
            [
                'event' => ProcessOrderCheckStockEvent::class,
                'identifier' => 'cart-products--order--stock-check-stock',
            ]
        )
    ;
};

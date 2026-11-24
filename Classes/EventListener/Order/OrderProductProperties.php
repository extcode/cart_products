<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Order;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\Order\BeforePersistOrderProductEvent;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;

/**
 * Takes over whether the product is shipped and whether it may be canceled and
 * returned when it is ordered. Virtual and downloadable products are never
 * shippable, cart derives that from the virtual product flag of the cart
 * product.
 */
final class OrderProductProperties
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {}

    public function __invoke(BeforePersistOrderProductEvent $event): void
    {
        $cartProduct = $event->getCartProduct();
        if ($cartProduct->getProductType() !== 'CartProducts') {
            return;
        }

        $options = $this->productRepository->findFulfillmentOptions($cartProduct->getProductId());
        if ($options === null) {
            return;
        }

        if (!$cartProduct->isVirtualProduct()) {
            $event->setShippable($options['shippable']);
        }
        $event->setCancelable($options['cancelable']);
        $event->setReturnable($options['returnable']);
    }
}

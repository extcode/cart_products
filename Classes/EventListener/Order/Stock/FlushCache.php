<?php

declare(strict_types=1);

namespace Extcode\CartProducts\EventListener\Order\Stock;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\Order\EventInterface;
use TYPO3\CMS\Core\Cache\CacheManager;

class FlushCache
{
    public function __construct(private readonly CacheManager $cacheManager) {}
    public function __invoke(EventInterface $event): void
    {
        $cartProducts = $event->getCart()->getProducts();

        foreach ($cartProducts as $cartProduct) {
            if ($cartProduct->getProductType() === 'CartProducts') {
                $cartProductId = $cartProduct->getProductId();

                $cacheTag = 'tx_cartproducts_product_' . $cartProductId;
                $cacheManager = $this->cacheManager;
                $cacheManager->flushCachesInGroupByTag('pages', $cacheTag);
            }
        }
    }
}

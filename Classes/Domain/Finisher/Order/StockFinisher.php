<?php

namespace Extcode\CartProducts\Domain\Finisher\Order;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Event\ProcessOrderCreateEvent;
use Extcode\CartProducts\Utility\StockUtility;

class StockFinisher
{
    /**
     * @var StockUtility
     */
    private $stockUtility;

    public function __construct(StockUtility $stockUtility)
    {
        $this->stockUtility = $stockUtility;
    }

    public function __invoke(ProcessOrderCreateEvent $event): void
    {
        $this->stockUtility->handleStock($event->getCart());
    }
}

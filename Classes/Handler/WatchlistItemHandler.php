<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Handler;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\WatchlistItemFactory;
use WerkraumMedia\Watchlist\Domain\ItemHandlerInterface;
use WerkraumMedia\Watchlist\Domain\Model\Item;

final readonly class WatchlistItemHandler implements ItemHandlerInterface
{
    public function __construct(
        private WatchlistItemFactory $watchlistItemFactory,
    ) {}

    public function return(string $identifier): ?Item
    {
        return $this->watchlistItemFactory->createFromIdentifier($identifier);
    }

    public function handlesType(): string
    {
        return 'CartProducts';
    }
}

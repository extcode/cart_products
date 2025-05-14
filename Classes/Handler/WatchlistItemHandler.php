<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Handler;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;
use Extcode\CartProducts\Domain\Model\WatchlistItem;
use WerkraumMedia\Watchlist\Domain\ItemHandlerInterface;
use WerkraumMedia\Watchlist\Domain\Model\Item;

final class WatchlistItemHandler implements ItemHandlerInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {}

    public function return(string $identifier): ?Item
    {
        list($uid, $detailPid) = explode('-', $identifier);

        $product = $this->productRepository->findProductByUid((int)$uid);

        if ($product === false) {
            return null;
        }

        return new WatchlistItem(
            (int)$uid,
            (int)$detailPid,
            (string)$product['title']
        );
    }

    public function handlesType(): string
    {
        return 'CartProducts';
    }
}

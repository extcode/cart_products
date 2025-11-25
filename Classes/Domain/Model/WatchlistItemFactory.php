<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Domain\Model;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;

final readonly class WatchlistItemFactory
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}

    public function createFromIdentifier(
        string $identifier,
    ): ?WatchlistItem {
        list($uid, $detailPid) = explode('-', $identifier);

        $product = $this->productRepository->findProductByUid((int)$uid);

        if ($product === false) {
            return null;
        }

        return new WatchlistItem(
            (int)$uid,
            (int)$detailPid,
            (string)$product['title'],
            $this->getFirstImageReference($product),
        );
    }

    private function getFirstImageReference(array $product): ?int
    {
        if (is_string($product['images'] ?? null) === false || $product['images'] === '') {
            return null;
        }

        $images = explode(',', $product['images']);

        $image = array_pop($images);

        if (is_numeric($image) === false) {
            return null;
        }

        return (int)$image;
    }
}

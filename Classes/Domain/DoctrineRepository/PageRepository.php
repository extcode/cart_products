<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Domain\DoctrineRepository;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class PageRepository
{
    private const TABLENAME = 'pages';

    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function getProductPageByProduct(Product $product): array|bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLENAME);

        return $queryBuilder->select('*')
            ->from(self::TABLENAME)
            ->where(
                $queryBuilder->expr()->eq('cart_products_product', $product->getUid())
            )
            ->orderBy('sorting')
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();
    }
}

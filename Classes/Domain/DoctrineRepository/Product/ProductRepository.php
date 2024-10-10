<?php

namespace Extcode\CartProducts\Domain\DoctrineRepository\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;

class ProductRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {}

    public function getStock(int $uid): int
    {
        $queryBuilder = $this
            ->connectionPool
            ->getConnectionForTable('tx_cartproducts_domain_model_product_product')
            ->createQueryBuilder();

        return $queryBuilder
            ->select('stock')
            ->from('tx_cartproducts_domain_model_product_product')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )->executeQuery()->fetchOne();
    }
}

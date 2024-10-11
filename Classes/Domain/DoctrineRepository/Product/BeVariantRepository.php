<?php

namespace Extcode\CartProducts\Domain\DoctrineRepository\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

class BeVariantRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {}

    public function getStock(int $uid): int
    {
        $queryBuilder = $this->getQueryBuilder();

        return $queryBuilder
            ->select('stock')
            ->from('tx_cartproducts_domain_model_product_bevariant')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->orWhere(
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->executeQuery()
            ->fetchOne();
    }

    public function addQuantityToStock(int $uid, int $quantity): void
    {
        $currentStock = $this->getStock($uid);

        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder
            ->update('tx_cartproducts_domain_model_product_bevariant')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->orWhere(
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT))
            )
            ->set('stock', $currentStock - $quantity)
            ->executeStatement();
    }

    public function subtractQuantityFromStock(int $uid, int $quantity): void
    {
        $quantity = -1 * $quantity;
        $this->addQuantityToStock($uid, $quantity);
    }

    private function getQueryBuilder(): QueryBuilder
    {
        return $this
            ->connectionPool
            ->getConnectionForTable('tx_cartproducts_domain_model_product_bevariant')
            ->createQueryBuilder();
    }
}

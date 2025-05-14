<?php

namespace Extcode\CartProducts\Domain\DoctrineRepository\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

class ProductRepository
{
    public const TABLENAME = 'tx_cartproducts_domain_model_product_product';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    /**
     * @return array<string,mixed>|false
     * @throws Exception
     */
    public function findProductByUid(int $uid)
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLENAME);

        return $queryBuilder
            ->select('product.title')
            ->from(self::TABLENAME, 'product')
            ->where($queryBuilder->expr()->eq('product.uid', $queryBuilder->createNamedParameter($uid)))
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();
    }

    public function getStock(int $uid): int
    {
        $queryBuilder = $this->getQueryBuilder();

        return $queryBuilder
            ->select('stock')
            ->from(self::TABLENAME)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->orWhere(
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->executeQuery()
            ->fetchOne();
    }

    public function addQuantityToStock(int $uid, int $quantity)
    {
        $currentStock = $this->getStock($uid);

        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder
            ->update(self::TABLENAME)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->orWhere(
                $queryBuilder->expr()->eq('l10n_parent', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->set('stock', $currentStock + $quantity)
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
            ->getConnectionForTable(self::TABLENAME)
            ->createQueryBuilder();
    }
}

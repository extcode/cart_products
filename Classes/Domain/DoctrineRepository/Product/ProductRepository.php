<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Domain\DoctrineRepository\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

class ProductRepository
{
    public const TABLENAME = 'tx_cartproducts_domain_model_product_product';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function findProductByUid(int $uid): array|bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLENAME);

        return $queryBuilder
            ->select('uid', 'title', 'images')
            ->from(self::TABLENAME)
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();
    }

    /**
     * Ignores the enable fields and the deleted flag: the product may have been
     * hidden or deleted after it was put into the cart.
     *
     * @return array{shippable: bool, cancelable: bool, returnable: bool}|null null if the product does not exist
     */
    public function findFulfillmentOptions(int $uid): ?array
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();

        $row = $queryBuilder
            ->select('shippable', 'cancelable', 'returnable')
            ->from(self::TABLENAME)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return [
            'shippable' => (bool)$row['shippable'],
            'cancelable' => (bool)$row['cancelable'],
            'returnable' => (bool)$row['returnable'],
        ];
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

    public function addQuantityToStock(int $uid, int $quantity): void
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

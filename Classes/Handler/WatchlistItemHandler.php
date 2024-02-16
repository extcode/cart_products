<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Handler;

use TYPO3\CMS\Core\Database\ConnectionPool;
use WerkraumMedia\Watchlist\Domain\ItemHandlerInterface;
use WerkraumMedia\Watchlist\Domain\Model\Item;

class WatchlistItemHandler implements ItemHandlerInterface
{
    /**
     * @var ConnectionPool
     */
    private $connectionPool;

    public function __construct(
        ConnectionPool $connectionPool
    ) {
        $this->connectionPool = $connectionPool;
    }

    public function return(string $identifier): ?Item
    {
        list($uid, $detailPid) = explode('-', $identifier);

        $productRecord = $this->getProductRecord((int)$uid);

        return new \Extcode\CartProducts\Domain\Model\WatchlistItem(
            (int)$uid,
            (int)$detailPid,
            (string)$productRecord['title']
        );
    }

    public function handlesType(): string
    {
        return 'CartProducts';
    }

    private function getProductRecord(int $uid): array
    {
        $qb = $this->connectionPool->getQueryBuilderForTable('tx_cartproducts_domain_model_product_product');
        $qb->select('product.title');
        $qb->from('tx_cartproducts_domain_model_product_product', 'product');
        $qb->where($qb->expr()->eq('product.uid', $qb->createNamedParameter($uid)));
        $qb->setMaxResults(1);
        return $qb->execute()->fetchAssociative() ?: [];
    }
}

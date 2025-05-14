<?php

namespace Extcode\CartProducts\Domain\DoctrineRepository;

use Doctrine\DBAL\Exception;
use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class PageRepository
{
    public const TABLENAME = 'pages';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    /**
     * @return array<string,mixed>|false
     * @throws Exception
     */
    public function getProductPageByProduct(Product $product)
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

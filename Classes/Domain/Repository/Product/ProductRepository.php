<?php

namespace Extcode\CartProducts\Domain\Repository\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ProductRepository extends Repository
{
    /**
     * @return QueryResultInterface|array
     */
    public function findDemanded(ProductDemand $demand)
    {
        $query = $this->createQuery();

        $constraints = [];

        if ($demand->getSku()) {
            $constraints[] = $query->equals('sku', $demand->getSku());
        }
        if ($demand->getTitle()) {
            $constraints[] = $query->like('title', '%' . $demand->getTitle() . '%');
        }

        if ((!empty($demand->getCategories()))) {
            $categoryConstraints = [];
            foreach ($demand->getCategories() as $category) {
                $categoryConstraints[] = $query->contains('category', $category);
                $categoryConstraints[] = $query->contains('categories', $category);
            }
            $constraints = $query->logicalOr($categoryConstraints);
        }

        if (!empty($constraints)) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }

        if ($orderings = $this->createOrderingsFromDemand($demand)) {
            $query->setOrderings($orderings);
        }

        return $query->execute();
    }

    /**
     * Find all products based on selected uids
     */
    public function findByUids(string $uids): array
    {
        $uids = explode(',', $uids);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $query->matching(
            $query->in('uid', $uids)
        );

        return $this->orderByField($query->execute(), $uids);
    }

    /**
     * @param ProductDemand $demand
     *
     * @return array<string>
     */
    protected function createOrderingsFromDemand(ProductDemand $demand): array
    {
        $orderings = [];

        $orderList = GeneralUtility::trimExplode(',', $demand->getOrder(), true);

        if (!empty($orderList)) {
            foreach ($orderList as $orderItem) {
                list($orderField, $orderDirection) =
                    GeneralUtility::trimExplode(' ', $orderItem, true);
                if (
                    $orderDirection &&
                    strtolower($orderDirection) === 'desc'
                ) {
                    $orderings[$orderField] = QueryInterface::ORDER_DESCENDING;
                } else {
                    $orderings[$orderField] = QueryInterface::ORDER_ASCENDING;
                }
            }
        }

        return $orderings;
    }

    protected function orderByField(QueryResultInterface $products, array $uids): array
    {
        $indexedProducts = [];
        $orderedProducts = [];

        // Create an associative array
        foreach ($products as $object) {
            $indexedProducts[$object->getUid()] = $object;
        }
        // add to ordered array in right order
        foreach ($uids as $uid) {
            if (isset($indexedProducts[$uid])) {
                $orderedProducts[] = $indexedProducts[$uid];
            }
        }

        return $orderedProducts;
    }
}

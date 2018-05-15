<?php

namespace Extcode\CartProducts\Domain\Repository\Product;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class ProductRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * @param ProductDemand $demand
     *
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
     *
     * @param string $uids
     *
     * @return array
     */
    public function findByUids($uids)
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
     * @param string $indexPids
     *
     * @return QueryResultInterface|array|null
     */
    public function findAllForIndexer($indexPids)
    {
        if (TYPO3_MODE === 'BE') {
            $query = $this->createQuery();

            $sql = '
                SELECT tx_cartproducts_domain_model_product_product.*, sys_category.cart_product_show_pid
                FROM tx_cartproducts_domain_model_product_product
                LEFT JOIN sys_category_record_mm
                    ON sys_category_record_mm.uid_foreign = tx_cartproducts_domain_model_product_product.category
                LEFT JOIN sys_category
                    ON sys_category_record_mm.uid_local = sys_category.uid
                WHERE
                  tx_cartproducts_domain_model_product_product.pid IN (?) AND
                  tx_cartproducts_domain_model_product_product.deleted=0 AND
                  tx_cartproducts_domain_model_product_product.hidden=0 AND
                  sys_category.deleted=0 AND
                  sys_category.hidden=0 AND
                  sys_category_record_mm.tablenames = "tx_cartproducts_domain_model_product_product" AND
                  sys_category_record_mm.fieldname = "category"';

            $preparedStatement = $this->objectManager->get(
                \TYPO3\CMS\Core\Database\PreparedStatement::class,
                $sql,
                'tx_cartproducts_domain_model_product_product'
            );

            $query->statement($preparedStatement, [$indexPids]);

            $result = $query->execute(true);
        }

        return $result;
    }

    /**
     * @param ProductDemand $demand
     *
     * @return array<\TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface>
     */
    protected function createOrderingsFromDemand(ProductDemand $demand)
    {
        $orderings = [];

        $orderList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $demand->getOrder(), true);

        if (!empty($orderList)) {
            foreach ($orderList as $orderItem) {
                list($orderField, $ascDesc) =
                    \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(' ', $orderItem, true);
                if ($ascDesc) {
                    $orderings[$orderField] = ((strtolower($ascDesc) == 'desc') ?
                        \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING :
                        \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                } else {
                    $orderings[$orderField] = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;
                }
            }
        }

        return $orderings;
    }

    /**
     * @param QueryResultInterface $products
     * @param array $uids
     *
     * @return array
     */
    protected function orderByField(QueryResultInterface $products, $uids)
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

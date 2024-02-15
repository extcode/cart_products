<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PageUidViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'product',
            Product::class,
            'product',
            true
        );

        $this->registerArgument(
            'settings',
            'array',
            'settings array',
            true
        );
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $product = $this->arguments['product'];

        $page = $this->getProductPage($product);

        if ($page) {
            return $page['uid'];
        } else {
            if ($product->getCategory() && $product->getCategory()->getCartProductShowPid()) {
                return $product->getCategory()->getCartProductShowPid();
            } elseif ($this->arguments['settings']['showPageUids']) {
                return $this->arguments['settings']['showPageUids'];
            }
        }

        return $GLOBALS['TSFE']->id;
    }

    /**
     * @return array|bool
     */
    protected function getProductPage(Product $product)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        return $queryBuilder->select('*')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('cart_products_product', $product->getUid())
            )
            ->orderBy('sorting')
            ->setMaxResults(1)
            ->execute()
            ->fetch();
    }
}

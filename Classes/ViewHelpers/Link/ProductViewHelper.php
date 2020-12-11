<?php

namespace Extcode\CartProducts\ViewHelpers\Link;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Link\ActionViewHelper;

class ProductViewHelper extends ActionViewHelper
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
     * @return string Rendered link
     */
    public function render(): string
    {
        $product = $this->arguments['product'];

        $page = $this->getProductPage($product);
        if ($page) {
            $this->arguments['pageUid'] = $page['uid'];
        } else {
            if ($product->getCategory() && $product->getCategory()->getCartProductShowPid()) {
                $this->arguments['pluginName'] = 'Products';
                $this->arguments['pageUid'] = $product->getCategory()->getCartProductShowPid();
            } elseif ($this->arguments['settings']['showPageUids']) {
                $this->arguments['pluginName'] = 'Products';
                $this->arguments['pageUid'] = $this->arguments['settings']['showPageUids'];
            }

            $this->arguments['action'] = 'show';
            $this->arguments['arguments'] = [
                'product' => $product
            ];
        }

        return parent::render();
    }

    /**
     * @param Product $product
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

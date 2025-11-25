<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\DoctrineRepository\PageRepository;
use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PageUidViewHelper extends AbstractViewHelper
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {}

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

    public function render(): string
    {
        $product = $this->arguments['product'];

        $page = $this->pageRepository->getProductPageByProduct($product);

        if ($page) {
            return $page['uid'];
        }
        if ($product->getCategory() && $product->getCategory()->getCartProductShowPid()) {
            return $product->getCategory()->getCartProductShowPid();
        }
        if ($this->arguments['settings']['showPageUids']) {
            return $this->arguments['settings']['showPageUids'];
        }

        return $GLOBALS['TSFE']->id;
    }
}

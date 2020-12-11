<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

class BestSpecialPriceDiscountViewHelper extends AbstractProductViewHelper
{
    /**
     * @return float
     */
    public function render(): float
    {
        $product = $this->arguments['product'];
        return $product->getBestSpecialPriceDiscount($this->getFrontendUserGroupIds());
    }
}

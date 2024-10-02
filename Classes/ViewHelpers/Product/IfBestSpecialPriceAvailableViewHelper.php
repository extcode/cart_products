<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class IfBestSpecialPriceAvailableViewHelper extends AbstractConditionViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument(
            'product',
            Product::class,
            'product for select options',
            true
        );
    }

    /**
     * @param array|null $arguments
     * @return bool
     * @api
     */
    protected static function evaluateCondition($arguments = null)
    {
        $product = $arguments['product'];
        $bestSpecialPrice = $product->getBestSpecialPrice(self::getFrontendUserGroupIds());
        return $bestSpecialPrice < $product->getMinPrice();
    }

    protected static function getFrontendUserGroupIds(): array
    {
        $context = GeneralUtility::makeInstance(Context::class);
        return $context->getPropertyFromAspect('frontend.user', 'groupIds') ?? [];
    }
}

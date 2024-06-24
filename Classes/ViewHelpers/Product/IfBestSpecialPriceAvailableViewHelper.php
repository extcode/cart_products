<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\FrontendUser;
use Extcode\Cart\Domain\Repository\FrontendUserRepository;
use Extcode\CartProducts\Domain\Model\Product\Product;
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

    /**
     * Get Frontend User Group
     *
     * @return array
     */
    protected static function getFrontendUserGroupIds(): array
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        if (!$user || !(int)$user['uid']) {
            return [];
        }

        $feGroupIds = [];

        $frontendUserRepository = GeneralUtility::makeInstance(
            FrontendUserRepository::class
        );
        $feUser = $frontendUserRepository->findByUid((int)$user['uid']);

        if (!$feUser instanceof FrontendUser) {
            return [];
        }

        $feGroups = $feUser->getUsergroup();
        foreach ($feGroups as $feGroup) {
            $feGroupIds[] = $feGroup->getUid();
        }

        return $feGroupIds;
    }
}

<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product\Product;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class IfBestSpecialPriceAvailableViewHelper extends AbstractConditionViewHelper
{
    /**
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments()
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
     * @param array|NULL $arguments
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
        $feGroupIds = [];
        $feUserId = (int)($GLOBALS['TSFE']->fe_user->user['uid'] ?? 0);
        if ($feUserId) {
            $frontendUserRepository = GeneralUtility::makeInstance(
                FrontendUserRepository::class
            );
            $feUser = $frontendUserRepository->findByUid($feUserId);
            $feGroups = $feUser->getUsergroup();
            if ($feGroups) {
                foreach ($feGroups as $feGroup) {
                    $feGroupIds[] = $feGroup->getUid();
                }
            }
        }
        return $feGroupIds;
    }
}

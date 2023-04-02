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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

abstract class AbstractProductViewHelper extends AbstractViewHelper
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
            'product',
            true
        );
    }

    /**
     * Get Frontend User Group
     *
     * @return array
     */
    protected function getFrontendUserGroupIds()
    {
        $user = $GLOBALS['TSFE']->fe_user->user;
        if (!$user || !(int)$user['uid']) {
            return [];
        }

        return $this->getFrontendUserIds((int)$user['uid']);
    }

    protected function getFrontendUserIds(int $feUserId): array
    {
        $feGroupIds = [];

        $frontendUserRepository = GeneralUtility::makeInstance(
            FrontendUserRepository::class
        );
        $feUser = $frontendUserRepository->findByUid($feUserId);

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

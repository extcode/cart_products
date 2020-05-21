<?php

namespace Extcode\CartProducts\ViewHelpers\Product;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * BestSpecialPrice ViewHelper
 *
 * @author Daniel Lorenz <ext.cart@extco.de>
 */
class BestSpecialPriceViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Output is escaped already. We must not escape children, to avoid double encoding.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'product',
            \Extcode\CartProducts\Domain\Model\Product\Product::class,
            'product',
            true
        );
    }

    /**
     * @return float
     */
    public function render()
    {
        $product = $this->arguments['product'];
        return $product->getBestSpecialPrice($this->getFrontendUserGroupIds());
    }

    /**
     * Get Frontend User Group
     *
     * @return array
     */
    protected function getFrontendUserGroupIds()
    {
        if (!$this->objectManager) {
            $this->objectManager = GeneralUtility::makeInstance(
                \TYPO3\CMS\Extbase\Object\ObjectManager::class
            );
        }
        $feGroupIds = [];
        $feUserId = (int)$GLOBALS['TSFE']->fe_user->user['uid'];
        if ($feUserId) {
            $frontendUserRepository = $this->objectManager->get(
                \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository::class
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

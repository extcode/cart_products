<?php

namespace Extcode\CartProducts\Utility;

/**
 * This file is part of the "cart_products" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class StockUtility
{
    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(
        \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    /**
     * Check Stock
     *
     * @var array $params
     */
    public function checkStock(array $params)
    {
        $cartProduct = $params['cartProduct'];
        $productStorageSettings = $params['productStorageSettings'];

        // TODO internal stock check
    }

    /**
     * Handle Stock
     *
     * @var array $params
     */
    public function handleStock(array $params)
    {
        $cartProduct = $params['cartProduct'];
        $productStorageSettings = $params['productStorageSettings'];

        // TODO internal stock check
    }
}

<?php

namespace Extcode\CartProducts\ViewHelpers;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class IsExtensionLoadedViewHelper extends AbstractConditionViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            'extKey',
            'string',
            '',
            true
        );
    }

    protected static function evaluateCondition($arguments = null)
    {
        $extKey = $arguments['extKey'];

        return ExtensionManagementUtility::isLoaded($extKey);
    }
}

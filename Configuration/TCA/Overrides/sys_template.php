<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function () {
    ExtensionManagementUtility::addStaticFile(
        'cart_products',
        'Configuration/TypoScript',
        'Shopping Cart - Cart Products'
    );
});

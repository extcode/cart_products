<?php

defined('TYPO3_MODE') or die();

$iconPath = 'EXT:cart_products/Resources/Public/Icons/';
$_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

/**
 * Register Backend Modules
 */
if (TYPO3_MODE === 'BE') {
    if (!isset($TBE_MODULES['Cart'])) {
        $temp_TBE_MODULES = [];
        foreach ($TBE_MODULES as $key => $val) {
            if ($key == 'file') {
                $temp_TBE_MODULES[$key] = $val;
                $temp_TBE_MODULES['Cart'] = '';
            } else {
                $temp_TBE_MODULES[$key] = $val;
            }
        }

        $TBE_MODULES = $temp_TBE_MODULES;
    }

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Extcode.cart_products',
        'Cart',
        'Products',
        '',
        [
            'Backend\Product' => 'list, show,',
            'Backend\Variant' => 'list, show, edit, update',
        ],
        [
            'access' => 'user, group',
            'icon' => $iconPath . 'module_products.svg',
            'labels' => $_LLL_be . 'tx_cartproducts.module.products',
            'navigationComponentId' => 'typo3-pagetree',
        ]
    );
}

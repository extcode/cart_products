<?php

defined('TYPO3_MODE') or die();

$_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

/**
 * Register Backend Modules
 */
if (TYPO3_MODE === 'BE') {
    if (!isset($GLOBALS['TBE_MODULES']['_configuration']['Cart'])) {
        $temp_TBE_MODULES = [];
        foreach ($GLOBALS['TBE_MODULES']['_configuration'] as $key => $val) {
            $temp_TBE_MODULES[$key] = $val;
            if ($key === 'file') {
                $temp_TBE_MODULES['Cart'] = '';

            }
        }

        $GLOBALS['TBE_MODULES']['_configuration'] = $temp_TBE_MODULES;
    }

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'CartProducts',
        'Cart',
        'Products',
        '',
        [
            \Extcode\CartProducts\Controller\Backend\ProductController::class => 'list, show,',
            \Extcode\CartProducts\Controller\Backend\VariantController::class => 'list, show, edit, update',
        ],
        [
            'access' => 'user, group',
            'icon' => 'EXT:cart_products/Resources/Public/Icons/module_products.svg',
            'labels' => $_LLL_be . 'tx_cartproducts.module.products',
            'navigationComponentId' => 'TYPO3/CMS/Backend/PageTree/PageTreeElement',
        ]
    );
}

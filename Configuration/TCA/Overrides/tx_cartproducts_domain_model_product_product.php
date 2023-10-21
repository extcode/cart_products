<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_LLL_db = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf:';

ExtensionManagementUtility::makeCategorizable(
    'cart_products',
    'tx_cartproducts_domain_model_product_product',
    'category',
    [
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_product_product.category',
        'fieldConfiguration' => [
            'minitems' => 0,
            'maxitems' => 1,
            'multiple' => false,
        ]
    ]
);

$GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['category']['config']['maxitems'] = 1;

ExtensionManagementUtility::makeCategorizable(
    'cart_products',
    'tx_cartproducts_domain_model_product_product',
    'categories',
    [
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_product_product.categories'
    ]
);

// category restriction based on settings in extension manager
$categoryRestrictionSetting = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('cart_products', 'categoryRestriction');

if ($categoryRestrictionSetting) {
    $categoryRestriction = '';
    switch ($categoryRestrictionSetting) {
        case 'current_pid':
            $categoryRestriction = ' AND sys_category.pid=###CURRENT_PID### ';
            break;
        case 'siteroot':
            $categoryRestriction = ' AND sys_category.pid IN (###SITEROOT###) ';
            break;
        case 'page_tsconfig':
            $categoryRestriction = ' AND sys_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ';
            break;
        default:
            $categoryRestriction = '';
    }

    // prepend category restriction at the beginning of foreign_table_where
    if (!empty($categoryRestriction)) {
        $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['category']['config']['foreign_table_where'] = $categoryRestriction .
            $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['category']['config']['foreign_table_where'];
        $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['categories']['config']['foreign_table_where'] = $categoryRestriction .
            $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['categories']['config']['foreign_table_where'];
    }
}

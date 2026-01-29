<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$_LLL_db = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf:';

// category restriction based on settings in extension manager
$categoryRestrictionSetting = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('cart_products', 'categoryRestriction');

if ($categoryRestrictionSetting) {
    $categoryRestriction = '';
    $categoryRestriction = match ($categoryRestrictionSetting) {
        'current_pid' => ' AND sys_category.pid=###CURRENT_PID### ',
        'siteroot' => ' AND sys_category.pid IN (###SITEROOT###) ',
        'page_tsconfig' => ' AND sys_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ',
        default => '',
    };

    // prepend category restriction at the beginning of foreign_table_where
    if (!empty($categoryRestriction)) {
        $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['category']['config']['foreign_table_where'] = $categoryRestriction
            . $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['category']['config']['foreign_table_where'];
        $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['categories']['config']['foreign_table_where'] = $categoryRestriction
            . $GLOBALS['TCA']['tx_cartproducts_domain_model_product_product']['columns']['categories']['config']['foreign_table_where'];
    }
}

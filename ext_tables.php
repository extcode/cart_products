<?php

defined('TYPO3_MODE') or die();

$iconPath = 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/';

$_LLL = 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xlf';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'Shopping Cart - Cart Products'
);

/**
 * Register Frontend Plugins
 */
$pluginNames = [
    'Products',
    'SingleProduct',
    'ProductPartial',
];

foreach ($pluginNames as $pluginName) {
    $pluginSignature = strtolower(str_replace('_', '', $_EXTKEY)) . '_' . strtolower($pluginName);
    $pluginNameSC = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Extcode.' . $_EXTKEY,
        $pluginName,
        $_LLL . ':tx_cartproducts.plugin.' . $pluginNameSC . '.title'
    );

    if ($pluginName == 'SingleProduct') {
        $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key, pages, recursive';
    } else {
        $TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'select_key';
    }

    $flexFormPath = 'EXT:' . $_EXTKEY . '/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
    if (file_exists(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($flexFormPath))) {
        $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:' . $flexFormPath
        );
    }
}

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
        'Extcode.' . $_EXTKEY,
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
            'labels' => $_LLL . ':tx_cartproducts.module.products',
            'navigationComponentId' => 'typo3-pagetree',
        ]
    );
}

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

$TCA['pages']['ctrl']['typeicon_classes']['contains-cartproducts'] = 'apps-pagetree-folder-cartproducts-products';

$tables = [
    'product_product',
    'product_specialprice',
    'product_taxclass',
    'product_fevariant',
    'product_bevariant',
    'product_bevariantattribute',
    'product_bevariantattributeoption',
];

foreach ($tables as $table) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
        'tx_cartproducts_domain_model_' . $table,
        'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_tx_cart_domain_model_' . $table . '.xlf'
    );
}

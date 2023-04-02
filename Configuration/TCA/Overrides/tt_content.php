<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function () {
    $_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

    $pluginNames = [
        'Products' => [
            'subtypes_excludelist' => 'select_key',
        ],
        'TeaserProducts' => [
            'subtypes_excludelist' => 'select_key, pages, recursive',
        ],
        'SingleProduct' => [
            'subtypes_excludelist' => 'select_key, pages, recursive',
        ],
    ];

    foreach ($pluginNames as $pluginName => $pluginConf) {
        $pluginSignature = 'cartproducts_' . strtolower($pluginName);
        $pluginNameSC = strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
        ExtensionUtility::registerPlugin(
            'CartProducts',
            $pluginName,
            $_LLL_be . 'tx_cartproducts.plugin.' . $pluginNameSC . '.title'
        );

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = $pluginConf['subtypes_excludelist'];

        $flexFormPath = 'EXT:cart_products/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
        if (file_exists(GeneralUtility::getFileAbsFileName($flexFormPath))) {
            $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
            ExtensionManagementUtility::addPiFlexFormValue(
                $pluginSignature,
                'FILE:' . $flexFormPath
            );
        }
    }

    $GLOBALS['TCA']['tt_content']['columns']['tx_cartproducts_domain_model_product_product']['config']['type'] = 'passthrough';
});

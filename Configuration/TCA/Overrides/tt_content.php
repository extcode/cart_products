<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;


$_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

$pluginNames = [
    'ShowProduct' => [
        'additionalFields' => '',
    ],
    'ListProducts' => [
        'additionalFields' => 'pages, recursive',
    ],
    'TeaserProducts' => [
        'additionalFields' => '',
    ],
    'SingleProduct' => [
        'additionalFields' => '',
    ],
];
    
foreach ($pluginNames as $pluginName => $pluginConf) {
    
    $pluginSignature = 'cartproducts_' . strtolower($pluginName);
    $pluginNameSC = strtolower((string)preg_replace('/[A-Z]/', '_$0', lcfirst($pluginName)));
    
    ExtensionUtility::registerPlugin(
        'CartProducts',
        $pluginName,
        $_LLL_be . 'tx_cartproducts.plugin.' . $pluginNameSC . '.title',
        null,
        'cart'
    );
    
    $flexFormPath = 'EXT:cart_products/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
    $additionalfields = $pluginConf['additionalFields'];
    if (is_file(GeneralUtility::getFileAbsFileName($flexFormPath))) {
        $additionalfields = trim('pi_flexform, ' . $pluginConf['additionalFields'], ' ,');
        ExtensionManagementUtility::addPiFlexFormValue(
            '*',
            'FILE:' . $flexFormPath,
            $pluginSignature,
        );
    }

    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--div--;Configuration,' . $additionalfields,
        $pluginSignature,
        'after:subheader',
    );
}

$GLOBALS['TCA']['tt_content']['columns']['tx_cartproducts_domain_model_product_product']['config']['type'] = 'passthrough';

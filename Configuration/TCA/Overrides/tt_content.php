<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

call_user_func(function () {
    $_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

    $pluginNames = [
        'ShowProduct' => [
            'pluginIcon' => 'ext-cartproducts-wizard-icon-list',
            'translationKeyPrefix' => $_LLL_be . 'tx_cartproducts.plugin.show_product',
        ],
        'ListProducts' => [
            'additionalNewFields' => 'pages, recursive',
            'pluginIcon' => 'ext-cartproducts-wizard-icon-show',
            'translationKeyPrefix' => $_LLL_be . 'tx_cartproducts.plugin.list_products',
        ],
        'TeaserProducts' => [
            'pluginIcon' => 'ext-cartproducts-wizard-icon-teaser',
            'translationKeyPrefix' => $_LLL_be . 'tx_cartproducts.plugin.teaser_products',
        ],
        'SingleProduct' => [
            'pluginIcon' => 'ext-cartproducts-wizard-icon-show',
            'translationKeyPrefix' => $_LLL_be . 'tx_cartproducts.plugin.single_product',
        ],
    ];

    foreach ($pluginNames as $pluginName => $pluginConf) {
        $pluginSignature = ExtensionUtility::registerPlugin(
            'cart_products',
            $pluginName,
            $pluginConf['translationKeyPrefix'] . '.title',
            $pluginConf['pluginIcon'],
            'cart',
            $pluginConf['translationKeyPrefix'] . '.description',
        );

        $flexFormPath = 'EXT:cart_products/Configuration/FlexForms/' . $pluginName . 'Plugin.xml';
        if (file_exists(GeneralUtility::getFileAbsFileName($flexFormPath))) {
            ExtensionManagementUtility::addToAllTCAtypes(
                'tt_content',
                rtrim('--div--;Configuration,pi_flexform,' . ($pluginConf['additionalNewFields'] ?? ''), ','),
                $pluginSignature,
                'after:subheader',
            );

            ExtensionManagementUtility::addPiFlexFormValue(
                '*',
                'FILE:' . $flexFormPath,
                $pluginSignature,
            );
        }
    }

    $GLOBALS['TCA']['tt_content']['columns']['tx_cartproducts_domain_model_product_product']['config']['type'] = 'passthrough';
});

<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$_LLL_db = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf:';
$_LLL_ttc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf';

$newSysCategoryColumns = [
    'images' => [
        'exclude' => 1,
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_category.image',
        'config' => [
            'type' => 'file',
            'appearance' => [
                'createNewRelationLinkTitle' => $_LLL_ttc . ':images.addFileReference',
                'showPossibleLocalizationRecords' => true,
                'showRemovedLocalizationRecords' => true,
                'showAllLocalizationLink' => true,
                'showSynchronizationLink' => true,
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
            'allowed' => 'common-image-types',
        ],
    ],
    'cart_product_list_pid' => [
        'exclude' => 1,
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_category.cart_product_list_pid',
        'config' => [
            'type' => 'group',
            'allowed' => 'pages',
            'size' => 1,
            'maxitems' => 1,
            'minitems' => 0,
            'default' => 0,
            'suggestOptions' => [
                'default' => [
                    'searchWholePhrase' => true,
                ],
            ],
        ],
    ],
    'cart_product_show_pid' => [
        'exclude' => 1,
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_category.cart_product_show_pid',
        'config' => [
            'type' => 'group',
            'allowed' => 'pages',
            'size' => 1,
            'maxitems' => 1,
            'minitems' => 0,
            'default' => 0,
            'suggestOptions' => [
                'default' => [
                    'searchWholePhrase' => true,
                ],
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('sys_category', $newSysCategoryColumns);
ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.options, images',
    '',
    'before:description'
);
ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    'cart_product_list_pid, cart_product_show_pid',
    '',
    'after:description'
);

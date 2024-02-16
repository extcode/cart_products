<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$_LLL_db = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf:';

$newSysCategoryColumns = [
    'images' => [
        'exclude' => 1,
        'label' => $_LLL_db . 'tx_cartproducts_domain_model_category.image',
        'config' => ExtensionManagementUtility::getFileFieldTCAConfig(
            'images',
            [
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                    'showPossibleLocalizationRecords' => 1,
                    'showRemovedLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'showSynchronizationLink' => 1
                ],
                'foreign_match_fields' => [
                    'fieldname' => 'images',
                    'tablenames' => 'sys_category',
                    'table_local' => 'sys_file',
                ],
            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        )
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
        ]
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
        ]
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

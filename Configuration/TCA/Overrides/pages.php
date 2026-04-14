<?php

defined('TYPO3') or die();

use Extcode\CartProducts\Constants;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function () {
    $_LLL_be = 'LLL:' . 'EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

    ArrayUtility::mergeRecursiveWithOverrule(
        $GLOBALS['TCA']['pages'],
        [
            'columns' => [
                'doktype' => [
                    'config' => [
                        'items' => [
                            1776196019 => [
                                'label' => $_LLL_be . 'pages.doktype.' . Constants::DOKTYPE_CARTPRODUCTS_PRODUCTS,
                                'value' => Constants::DOKTYPE_CARTPRODUCTS_PRODUCTS,
                                'icon' => 'apps-pagetree-page-cartproducts-products',
                                'group' => 'default',
                            ],
                            1776196036 => [
                                'label' => $_LLL_be . 'pages.doktype.' . Constants::DOKTYPE_CARTPRODUCTS_PRODUCT,
                                'value' => Constants::DOKTYPE_CARTPRODUCTS_PRODUCT,
                                'icon' => 'apps-pagetree-page-cartproducts-products',
                                'group' => 'default',
                            ],
                        ],
                    ],
                ],
                'module' => [
                    'config' => [
                        'items' => [
                            1776196062 => [
                                'label' => $_LLL_be . 'tcarecords-pages-contains.cart_products',
                                'value' => 'cartproducts',
                                'icon' => 'apps-pagetree-folder-cartproducts-products',
                            ],
                        ],
                    ],
                ],
            ],
            'ctrl' => [
                'typeicon_classes' => [
                    Constants::DOKTYPE_CARTPRODUCTS_PRODUCTS => 'apps-pagetree-page-cartproducts-products',
                    Constants::DOKTYPE_CARTPRODUCTS_PRODUCT => 'apps-pagetree-page-cartproducts-products',
                    'contains-cartproducts' => 'apps-pagetree-folder-cartproducts-products',
                ],
            ],
            'types' => [
                Constants::DOKTYPE_CARTPRODUCTS_PRODUCTS => $GLOBALS['TCA']['pages']['types'][(string)\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT],
                Constants::DOKTYPE_CARTPRODUCTS_PRODUCT => $GLOBALS['TCA']['pages']['types'][(string)\TYPO3\CMS\Core\Domain\Repository\PageRepository::DOKTYPE_DEFAULT],
            ],
        ]
    );

    $newPagesColumns = [
        'cart_products_product' => [
            'displayCond' => 'FIELD:doktype:=:183',
            'exclude' => true,
            'label' => $_LLL_be . 'pages.singleview_cart_products_product',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_cartproducts_domain_model_product_product',
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'size' => 1,
            ],
        ],
    ];

    ExtensionManagementUtility::addTCAcolumns(
        'pages',
        $newPagesColumns
    );

    ExtensionManagementUtility::addFieldsToPalette(
        'pages',
        'standard',
        ',--linebreak--,cart_products_product',
        'after:doktype'
    );
});

<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {
    $_LLL_be = 'LLL:' . 'EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL_be . 'pages.doktype.182',
        182,
        'apps-pagetree-page-cartproducts-products'
    ];
    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL_be . 'pages.doktype.183',
        183,
        'apps-pagetree-page-cartproducts-products'
    ];
    $GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = [
        'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:tcarecords-pages-contains.cart_products',
        'cartproducts',
        'apps-pagetree-folder-cartproducts-products',
    ];

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][182] = 'apps-pagetree-page-cartproducts-products';
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][183] = 'apps-pagetree-page-cartproducts-products';
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes']['contains-cartproducts'] = 'apps-pagetree-folder-cartproducts-products';

    $newPagesColumns = [
        'cart_products_product' => [
            'displayCond' => 'FIELD:doktype:=:183',
            'exclude' => true,
            'label' => $_LLL_be . 'pages.singleview_cart_products_product',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_cartproducts_domain_model_product_product',
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'size' => 1,
            ],
        ],
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'pages',
        $newPagesColumns
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
        'pages',
        'standard',
        ',--linebreak--,cart_products_product',
        'after:doktype'
    );
});

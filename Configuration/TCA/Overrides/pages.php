<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {
    $_LLL = 'LLL:' . 'EXT:cart_products/Resources/Private/Language/locallang_be.xlf';

    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL . ':pages.doktype.182',
        182,
        'icon-apps-pagetree-cartproducts-page'
    ];

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][182] = 'icon-apps-pagetree-cartproducts-page';

    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL . ':pages.doktype.183',
        183,
        'icon-apps-pagetree-cartproducts-page'
    ];

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][183] = 'icon-apps-pagetree-cartproducts-page';

    $newPagesColumns = [
        'cart_products_product' => [
            'displayCond' => 'FIELD:doktype:=:183',
            'exclude' => true,
            'label' => $_LLL . ':pages.singleview_cart_products_product',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_cartproducts_domain_model_product_product',
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'minitems' => 0,
                'maxitems' => 1,
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

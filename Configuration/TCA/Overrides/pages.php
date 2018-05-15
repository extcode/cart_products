<?php
defined('TYPO3_MODE') or die();

call_user_func(function () {
    $_LLL = 'LLL:' . 'EXT:cart_products/Resources/Private/Language/locallang_db.xlf:';

    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        $_LLL . 'pages.doktype.182',
        182,
        'icon-apps-pagetree-cartproducts-page'
    ];

    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][182] = 'icon-apps-pagetree-cartproducts-page';
});

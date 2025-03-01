<?php

defined('TYPO3') or die();

use Extcode\CartProducts\Controller\ProductController;
use Extcode\CartProducts\Hooks\DataHandler;
use Extcode\CartProducts\Hooks\DatamapDataHandlerHook;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

// configure plugins
ExtensionUtility::configurePlugin(
    'cart_products',
    'ShowProduct',
    [
        ProductController::class => 'show, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'ListProducts',
    [
        ProductController::class => 'list, show, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'TeaserProducts',
    [
        ProductController::class => 'teaser, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'SingleProduct',
    [
        ProductController::class => 'show, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'ProductPartial',
    [
        ProductController::class => 'showForm',
    ],
    [
        ProductController::class => 'showForm',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Cart Hooks

// processDatamapClass Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['cartproducts_allowed']
    = DatamapDataHandlerHook::class;

// clearCachePostProc Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['cartproducts_clearcache']
    = DataHandler::class . '->clearCachePostProc';

// register "cartproducts:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartproducts'][]
    = 'Extcode\\CartProducts\\ViewHelpers';

// register listTemplateLayouts
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['list_products'][] = [$_LLL_be . 'flexforms_template.templateLayout.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['list_products'][] = [$_LLL_be . 'flexforms_template.templateLayout.grid', 'grid'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['teaser_products'][] = [$_LLL_be . 'flexforms_template.templateLayout.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['teaser_products'][] = [$_LLL_be . 'flexforms_template.templateLayout.grid', 'grid'];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][Category::class] = [
    'className' => \Extcode\CartProducts\Domain\Model\Category::class,
];

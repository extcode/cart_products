<?php

use Extcode\CartProducts\Controller\ProductController;
use Extcode\CartProducts\Hooks\DataHandler;
use Extcode\CartProducts\Hooks\DatamapDataHandlerHook;
use Extcode\CartProducts\Updates\SlugUpdater;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$_LLL_be = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_be.xlf:';

// configure plugins

ExtensionUtility::configurePlugin(
    'cart_products',
    'Products',
    [
        ProductController::class => 'show, list, teaser, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ]
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'TeaserProducts',
    [
        ProductController::class => 'teaser, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ]
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'SingleProduct',
    [
        ProductController::class => 'show, showForm',
    ],
    [
        ProductController::class => 'showForm',
    ]
);

ExtensionUtility::configurePlugin(
    'cart_products',
    'ProductPartial',
    [
        ProductController::class => 'showForm',
    ],
    [
        ProductController::class => 'showForm',
    ]
);

// Icon Registry

$icons = [
    'apps-pagetree-folder-cartproducts-products' => 'apps_pagetree_folder_cartproducts_products.svg',
    'apps-pagetree-page-cartproducts-products' => 'apps_pagetree_page_cartproducts_products.svg',
    'ext-cartproducts-extension-icon' => 'Extension.svg',
    'ext-cartproducts-wizard-icon' => 'cartproducts_plugin_wizard.svg',
];

$iconRegistry = GeneralUtility::makeInstance(
    IconRegistry::class
);

foreach ($icons as $identifier => $fileName) {
    $iconRegistry->registerIcon(
        $identifier,
        SvgIconProvider::class,
        [
            'source' => 'EXT:cart_products/Resources/Public/Icons/' . $fileName,
        ]
    );
}

// TSconfig

ExtensionManagementUtility::addPageTSConfig('
    <INCLUDE_TYPOSCRIPT: source="FILE:EXT:cart_products/Configuration/TSconfig/ContentElementWizard.tsconfig">
');

// Cart Hooks

// processDatamapClass Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['cartproducts_allowed'] =
    DatamapDataHandlerHook::class;

// clearCachePostProc Hook

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc']['cartproducts_clearcache'] =
    DataHandler::class . '->clearCachePostProc';

// register "cartproducts:" namespace
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['cartproducts'][]
    = 'Extcode\\CartProducts\\ViewHelpers';

// update wizard for slugs
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['cartProductsSlugUpdater'] =
    SlugUpdater::class;

// register listTemplateLayouts
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['products'][] = [$_LLL_be . 'flexforms_template.templateLayout.products.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['products'][] = [$_LLL_be . 'flexforms_template.templateLayout.products.grid', 'grid'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['teaser_products'][] = [$_LLL_be . 'flexforms_template.templateLayout.products.table', 'table'];
$GLOBALS['TYPO3_CONF_VARS']['EXT']['cart_products']['templateLayouts']['teaser_products'][] = [$_LLL_be . 'flexforms_template.templateLayout.products.grid', 'grid'];

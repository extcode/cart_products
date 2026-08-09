<?php

defined('TYPO3') or die();

use Extcode\CartProducts\Controller\ProductController;
use Extcode\CartProducts\Hooks\DataHandler;
use Extcode\CartProducts\Hooks\DatamapDataHandlerHook;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

(static function (string $extKey): void {
    $_LLL_be = 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf:';

    if (is_array($GLOBALS['TYPO3_CONF_VARS'] ?? null) === false) {
        throw new \Exception('$GLOBALS[\'TYPO3_CONF_VARS\'] is not an array', 1774601240);
    }

    ArrayUtility::mergeRecursiveWithOverrule(
        $GLOBALS['TYPO3_CONF_VARS'],
        [
            'EXT' => [
                $extKey => [
                    'templateLayouts' => [
                        'list_products' => [
                            'table' => [$_LLL_be . 'flexforms_template.templateLayout.table', 'table'],
                            'grid' => [$_LLL_be . 'flexforms_template.templateLayout.grid', 'grid'],
                        ],
                        'teaser_products' => [
                            'table' => [$_LLL_be . 'flexforms_template.templateLayout.table', 'table'],
                            'grid' => [$_LLL_be . 'flexforms_template.templateLayout.grid', 'grid'],
                        ],
                    ],
                ],
            ],
            'SC_OPTIONS' => [
                't3lib/class.t3lib_tcemain.php' => [
                    'processDatamapClass' => [
                        'cartproducts_allowed' => DatamapDataHandlerHook::class,
                    ],
                    'clearCachePostProc' => [
                        'cartproducts_clearcache' => DataHandler::class . '->clearCachePostProc',
                    ],
                ],
            ],
            'SYS' => [
                'fluid' => [
                    'namespaces' => [
                        'cartproducts' => [
                            1 => 'Extcode\\CartProducts\\ViewHelpers',
                        ],
                    ],
                ],
            ],
        ]
    );

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

})('cart_products');

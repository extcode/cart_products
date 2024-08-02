<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'apps-pagetree-folder-cartproducts-products' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_products/Resources/Public/Icons/apps_pagetree_folder_cartproducts_products.svg',
    ],
    'apps-pagetree-page-cartproducts-products' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_products/Resources/Public/Icons/apps_pagetree_page_cartproducts_products.svg',
    ],
    'ext-cartproducts-extension-icon' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_products/Resources/Public/Icons/Extension.svg',
    ],
    'ext-cartproducts-wizard-icon-list' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_products/Resources/Public/Icons/cartproducts_plugin_wizard-list.svg',
    ],
    'ext-cartproducts-wizard-icon-show' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_products/Resources/Public/Icons/cartproducts_plugin_wizard-show.svg',
    ],
    'ext-cartproducts-wizard-icon-teaser' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cart_products/Resources/Public/Icons/cartproducts_plugin_wizard-teaser.svg',
    ],
];

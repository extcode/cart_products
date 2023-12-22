<?php

defined('TYPO3') or die();

$_LLL_general = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf';
$_LLL = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => $_LLL . ':tx_cartproducts_domain_model_product_quantitydiscount',
        'label' => 'quantity',
        'label_alt' => 'price',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',

        'versioningWS' => true,

        'hideTable' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'fe_group' => 'frontend_user_group'
        ],
        'searchFields' => 'price',
        'iconfile' => 'EXT:cart_products/Resources/Public/Icons/Product/QuantityDiscount.png'
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, frontend_user_group, quantity, price'],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [

        't3ver_label' => [
            'label' => $_LLL_general . ':LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],

        'hidden' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],

        'quantity' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_quantitydiscount.quantity',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,int',
                'default' => '0',
            ]
        ],
        'price' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_quantitydiscount.price',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'required,double2',
                'default' => '0.00',
            ]
        ],

        'frontend_user_group' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_quantitydiscount.frontend_user_group',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'readOnly' => 0,
                'foreign_table' => 'fe_groups',
                'size' => 1,
                'items' => [
                    ['', 0],
                ],
                'minitems' => 0,
                'maxitems' => 1,
            ]
        ],

        'product' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];

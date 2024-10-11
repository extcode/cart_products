<?php

defined('TYPO3') or die();

$_LLL_general = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf';
$_LLL = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => $_LLL . ':tx_cartproducts_domain_model_product_fevariant',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'hideTable' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title',
        'iconfile' => 'EXT:cart_products/Resources/Public/Icons/Product/FeVariant.png',
    ],
    'types' => [
        '1' => [
            'showitem' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,is_required,sku,title,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access',
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [

        'sys_language_uid' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => $_LLL_general . ':LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_cartproducts_domain_model_product_fevariant',
                'foreign_table_where' => 'AND tx_cartproducts_domain_model_product_fevariant.pid=###CURRENT_PID### AND tx_cartproducts_domain_model_product_fevariant.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => $_LLL_general . ':LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],

        'is_required' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_fevariant.is_required',
            'config' => [
                'type' => 'check',
            ],
        ],
        'sku' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_fevariant.sku',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'title' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_fevariant.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'product' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

    ],
];

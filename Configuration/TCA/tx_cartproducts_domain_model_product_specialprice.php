<?php

defined('TYPO3') or die();

$_LLL_general = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf';
$_LLL = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => $_LLL . ':tx_cartproducts_domain_model_product_specialprice',
        'label' => 'price',
        'label_alt' => 'starttime, endtime',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',

        'versioningWS' => true,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'hideTable' => true,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'frontend_user_group',
        ],
        'searchFields' => 'price',
        'iconfile' => 'EXT:cart_products/Resources/Public/Icons/Product/SpecialPrice.png',
    ],
    'types' => [
        '1' => [
            'showitem' => 'frontend_user_group,title,price,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;hiddenonly,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access',
        ],
    ],
    'palettes' => [
        '1' => [
            'showitem' => '',
        ],
        'hiddenonly' => [
            'showitem' => 'hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:hidden_formlabel',
        ],
        'access' => [
            'showitem' => 'starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel, endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel',
        ],
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
                'foreign_table' => 'tx_cartproducts_domain_model_product_specialprice',
                'foreign_table_where' => 'AND tx_cartproducts_domain_model_product_specialprice.pid=###CURRENT_PID### AND tx_cartproducts_domain_model_product_specialprice.sys_language_uid IN (-1,0)',
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
        'starttime' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'size' => 13,
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => $_LLL_general . ':LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'size' => 13,
                'checkbox' => 0,
                'default' => 0,
            ],
        ],

        'title' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_specialprice.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'price' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_specialprice.price',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => '0.00',
                'required' => true,
                'format' => 'decimal',
            ],
        ],

        'frontend_user_group' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_specialprice.frontend_user_group',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'readOnly' => 0,
                'foreign_table' => 'fe_groups',
                'size' => 1,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
            ],
        ],

        'product' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];

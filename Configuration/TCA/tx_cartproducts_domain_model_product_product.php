<?php

defined('TYPO3') or die();

$_LLL_general = 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf';
$_LLL_tca = 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf';
$_LLL_ttc = 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf';
$_LLL = 'LLL:EXT:cart_products/Resources/Private/Language/locallang_db.xlf';
$_LLL_cart = 'LLL:EXT:cart/Resources/Private/Language/locallang_db.xlf';

return [
    'ctrl' => [
        'title' => $_LLL . ':tx_cartproducts_domain_model_product_product',
        'label' => 'sku',
        'label_alt' => 'title',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',

        'sortby' => 'sorting',

        'versioningWS' => true,

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'searchFields' => 'sku,title,teaser,description,price,',
        'iconfile' => 'EXT:cart_products/Resources/Public/Icons/tx_cartproducts_domain_model_product_product.svg',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid, l10n_parent, l10n_diffsource,
                product_type, sku, title,
                path_segment,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.descriptions,
                    teaser, description,
                    product_content,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.images_and_files,
                    header_image, images, files,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.prices,
                    --palette--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.palette.minmax;minmax,
                    --palette--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.palette.prices;prices,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.measures,    
                    --palette--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.palette.measures;measures,
                    --palette--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.palette.service_attributes;service_attributes,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.stock,
                    handle_stock, handle_stock_in_variants, stock,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.variants,
                    fe_variants,
                    --palette--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.palette.be_variant_attributes;be_variant_attributes,
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.related_products,
                    related_products,  
                --div--;' . $_LLL . ':tx_cartproducts_domain_model_product_product.div.tags_categories,
                    tags, category, categories,
                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.access,
                        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.visibility;hiddenonly,
                        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.access;access,
            ',
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
            'showitem' => '
                starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel, 
                endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                --linebreak--,
                fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel,',
        ],
        'be_variant_attributes' => [
            'showitem' => 'be_variant_attribute1, be_variant_attribute2, be_variant_attribute3, --linebreak--, be_variants',
            'canNotCollapse' => 1,
        ],
        'minmax' => [
            'showitem' => 'min_number_in_order, max_number_in_order',
            'canNotCollapse' => 1,
        ],
        'prices' => [
            'showitem' => 'is_net_price, --linebreak--, price, tax_class_id, --linebreak--, special_prices, quantity_discounts',
            'canNotCollapse' => 1,
        ],
        'measures' => [
            'showitem' => 'price_measure, price_measure_unit, base_price_measure_unit',
            'canNotCollapse' => 1,
        ],
        'service_attributes' => [
            'showitem' => 'service_attribute1, service_attribute2, service_attribute3',
            'canNotCollapse' => 1,
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
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'foreign_table_where' => 'AND tx_cartproducts_domain_model_product_product.pid=###CURRENT_PID### AND tx_cartproducts_domain_model_product_product.sys_language_uid IN (-1,0)',
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
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
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
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'fe_group' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_group',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'size' => 5,
                'maxitems' => 20,
                'items' => [
                    [
                        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login',
                        'value' => -1,
                    ],
                    [
                        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.any_login',
                        'value' => -2,
                    ],
                    [
                        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.usergroups',
                        'value' => '--div--',
                    ],
                ],
                'exclusiveKeys' => '-1,-2',
                'foreign_table' => 'fe_groups',
            ],
        ],
        'product_type' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.product_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.product_type.simple', 'value' => 'simple'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.product_type.configurable', 'value' => 'configurable'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.product_type.virtual', 'value' => 'virtual'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.product_type.downloadable', 'value' => 'downloadable'],
                ],
                'default' => 'simple',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
            'onChange' => 'reload',
            'l10n_mode' => 'exclude',
        ],

        'sku' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.sku',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],

        'title' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],

        'path_segment' => [
            'exclude' => true,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['title'],
                    'replacements' => [
                        '/' => '',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => '',
            ],
        ],

        'teaser' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.teaser',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],

        'description' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
            ],
        ],

        'min_number_in_order' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.min_number_in_order',
            'config' => [
                'type' => 'number',
                'size' => 30,
            ],
        ],

        'max_number_in_order' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.max_number_in_order',
            'config' => [
                'type' => 'number',
                'size' => 30,
            ],
        ],

        'is_net_price' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.is_net_price',
            'config' => [
                'type' => 'check',
            ],
        ],

        'price' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.price',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => '0.00',
                'required' => true,
                'format' => 'decimal',
            ],
        ],

        'special_prices' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.special_prices',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cartproducts_domain_model_product_specialprice',
                'foreign_field' => 'product',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_specialprice.pid=###CURRENT_PID### ',
                'foreign_default_sortby' => 'price ASC',
                'maxitems' => 99,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                ],
            ],
        ],

        'quantity_discounts' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.quantity_discounts',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cartproducts_domain_model_product_quantitydiscount',
                'foreign_field' => 'product',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_quantitydiscount.pid=###CURRENT_PID### ',
                'foreign_default_sortby' => 'quantity ASC',
                'maxitems' => 99,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                ],
            ],
        ],

        'price_measure' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.price_measure',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => '0.00',
                'format' => 'decimal',
            ],
        ],

        'price_measure_unit' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.price_measure_unit',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.no_measuring_unit', 'value' => 0],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.weight', 'value' => '--div--'],
                    ['label' => 'mg', 'value' => 'mg'],
                    ['label' => 'g', 'value' => 'g'],
                    ['label' => 'kg', 'value' => 'kg'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.volume', 'value' => '--div--'],
                    ['label' => 'ml', 'value' => 'ml'],
                    ['label' => 'cl', 'value' => 'cl'],
                    ['label' => 'l', 'value' => 'l'],
                    ['label' => 'cbm', 'value' => 'cbm'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.length', 'value' => '--div--'],
                    ['label' => 'cm', 'value' => 'cm'],
                    ['label' => 'm', 'value' => 'm'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.area', 'value' => '--div--'],
                    ['label' => 'm²', 'value' => 'm2'],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'base_price_measure_unit' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.base_price_measure_unit',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.no_measuring_unit', 'value' => 0],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.weight', 'value' => '--div--'],
                    ['label' => 'mg', 'value' => 'mg'],
                    ['label' => 'g', 'value' => 'g'],
                    ['label' => 'kg', 'value' => 'kg'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.volume', 'value' => '--div--'],
                    ['label' => 'ml', 'value' => 'ml'],
                    ['label' => 'cl', 'value' => 'cl'],
                    ['label' => 'l', 'value' => 'l'],
                    ['label' => 'cbm', 'value' => 'cbm'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.length', 'value' => '--div--'],
                    ['label' => 'cm', 'value' => 'cm'],
                    ['label' => 'm', 'value' => 'm'],
                    ['label' => $_LLL . ':tx_cartproducts_domain_model_product_product.measure.area', 'value' => '--div--'],
                    ['label' => 'm²', 'value' => 'm2'],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'service_attribute1' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.service_attribute1',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => '0.00',
                'required' => true,
                'format' => 'decimal',
            ],
        ],
        'service_attribute2' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.service_attribute2',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => '0.00',
                'required' => true,
                'format' => 'decimal',
            ],
        ],
        'service_attribute3' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.service_attribute3',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => '0.00',
                'required' => true,
                'format' => 'decimal',
            ],
        ],

        'tax_class_id' => [
            'exclude' => 1,
            'label' => $_LLL_cart . ':tx_cart.tax_class_id',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $_LLL_cart . ':tx_cart.tax_class_id.1', 'value' => 1],
                    ['label' => $_LLL_cart . ':tx_cart.tax_class_id.2', 'value' => 2],
                    ['label' => $_LLL_cart . ':tx_cart.tax_class_id.3', 'value' => 3],
                ],
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],

        'be_variant_attribute1' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:product_type:=:configurable',
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.be_variant_attribute1',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_cartproducts_domain_model_product_bevariantattribute',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_bevariantattribute.pid=###CURRENT_PID### ORDER BY tx_cartproducts_domain_model_product_bevariantattribute.title ',
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => 'int',
                'default' => 0,
            ],
            'onChange' => 'reload',
        ],

        'be_variant_attribute2' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:product_type:=:configurable',
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.be_variant_attribute2',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_cartproducts_domain_model_product_bevariantattribute',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_bevariantattribute.pid=###CURRENT_PID### ORDER BY tx_cartproducts_domain_model_product_bevariantattribute.title ',
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => 'int',
                'default' => 0,
            ],
            'onChange' => 'reload',
        ],

        'be_variant_attribute3' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:product_type:=:configurable',
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.be_variant_attribute3',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_cartproducts_domain_model_product_bevariantattribute',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_bevariantattribute.pid=###CURRENT_PID### ORDER BY tx_cartproducts_domain_model_product_bevariantattribute.title ',
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => 'int',
                'default' => 0,
            ],
            'onChange' => 'reload',
        ],

        'fe_variants' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.fe_variants',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cartproducts_domain_model_product_fevariant',
                'foreign_field' => 'product',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_fevariant.pid=###CURRENT_PID### ORDER BY tx_cartproducts_domain_model_product_fevariant.title ',
                'foreign_sortby' => 'sorting',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'info' => true,
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => true,
                        'hide' => true,
                        'delete' => true,
                        'localize' => true,
                    ],
                ],
            ],
        ],

        'be_variants' => [
            'exclude' => 1,
            'displayCond' => 'FIELD:product_type:=:configurable',
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.be_variants',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cartproducts_domain_model_product_bevariant',
                'foreign_field' => 'product',
                'foreign_table_where' => ' AND tx_cartproducts_domain_model_product_bevariant.pid=###CURRENT_PID### ORDER BY tx_cartproducts_domain_model_product_bevariant.title ',
                'foreign_sortby' => 'sorting',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'info' => true,
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => true,
                        'hide' => true,
                        'delete' => true,
                        'localize' => true,
                    ],
                ],
            ],
        ],

        'related_products' => [
            'exclude' => 1,
            'label' => $_LLL . 'tx_cartproducts_domain_model_product_product.related_products',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_cartproducts_domain_model_product_product',
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'MM_opposite_field' => 'related_products_from',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_cartproducts_domain_model_product_product_related_mm',
                'suggestOptions' => [
                    'default' => [
                        'searchWholePhrase' => true,
                    ],
                ],
            ],
        ],

        'related_products_from' => [
            'exclude' => 1,
            'label' => $_LLL . 'tx_cartproducts_domain_model_product_product.related_products_from',
            'config' => [
                'type' => 'group',
                'foreign_table' => 'tx_cartproducts_domain_model_product_product',
                'allowed' => 'tx_cartproducts_domain_model_product_product',
                'size' => 5,
                'maxitems' => 100,
                'MM' => 'tx_cartproducts_domain_model_product_product_related_mm',
                'readOnly' => 1,
            ],
        ],

        'images' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.images',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => $_LLL_ttc . ':images.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'allowed' => 'common-image-types',
            ],
        ],

        'files' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.files',
            'config' => [
                'type' => 'file',
                'appearance' => [
                    'createNewRelationLinkTitle' => $_LLL_ttc . ':media.addFileReference',
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'allowed' => 'common-media-types',
            ],
        ],

        'product_content' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.product_content',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tt_content',
                'foreign_field' => 'tx_cartproducts_domain_model_product_product',
                'foreign_sortby' => 'sorting',
                'minitems' => 0,
                'maxitems' => 99,
                'appearance' => [
                    'levelLinksPosition' => 'top',
                    'showPossibleLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                    'enabledControls' => [
                        'info' => true,
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => true,
                        'hide' => true,
                        'delete' => true,
                        'localize' => true,
                    ],
                ],
                'inline' => [
                    'inlineNewButtonStyle' => 'display: inline-block;',
                ],
            ],
        ],

        'handle_stock' => [
            'exclude' => 1,
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.handle_stock',
            'config' => [
                'type' => 'check',
            ],
            'onChange' => 'reload',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'handle_stock_in_variants' => [
            'exclude' => 1,
            'displayCond' => [
                'AND' => [
                    'FIELD:product_type:=:configurable',
                    'FIELD:handle_stock:=:1',
                ],
            ],
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.handle_stock_in_variants',
            'config' => [
                'type' => 'check',
            ],
            'onChange' => 'reload',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],
        'stock' => [
            'exclude' => 1,
            'displayCond' => [
                'AND' => [
                    'FIELD:handle_stock:=:1',
                    'FIELD:handle_stock_in_variants:=:0',
                ],
            ],
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.stock',
            'config' => [
                'type' => 'number',
                'size' => 30,
                'default' => 0,
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
        ],

        'category' => [
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.category',
            'config' => [
                'type' => 'category',
                'relationship' => 'oneToOne',
            ],
        ],

        'categories' => [
            'label' => $_LLL . ':tx_cartproducts_domain_model_product_product.categories',
            'config' => [
                'type' => 'category',
            ],
        ],

        'tags' => [
            'exclude' => 1,
            'label' => $_LLL_cart . ':tx_cart_domain_model_tag',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_cart_domain_model_tag',
                'foreign_table' => 'tx_cart_domain_model_tag',
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 100,
                'MM' => 'tx_cartproducts_domain_model_product_tag_mm',
                'suggestOptions' => [
                    'default' => [
                        'searchWholePhrase' => true,
                    ],
                ],
            ],
        ],
    ],
];

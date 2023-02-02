<?php

$EM_CONF['cart_products'] = [
    'title' => 'Cart - Products',
    'description' => 'Shopping Cart(s) for TYPO3 - Products',
    'category' => 'plugin',
    'shy' => false,
    'version' => '4.1.0',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'stable',
    'uploadfolder' => false,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => true,
    'lockType' => '',
    'author' => 'Daniel Gohlke',
    'author_email' => 'ext.cart@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'CGLcompliance' => null,
    'CGLcompliance_note' => null,
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'cart' => '8.0.0'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Cart - Products',
    'description' => 'Shopping Cart(s) for TYPO3 - Products',
    'category' => 'plugin',
    'shy' => false,
    'version' => '0.3.0',
    'dependencies' => '',
    'conflicts' => '',
    'priority' => '',
    'loadOrder' => '',
    'module' => '',
    'state' => 'alpha',
    'uploadfolder' => false,
    'createDirs' => '',
    'modify_tables' => '',
    'clearcacheonload' => true,
    'lockType' => '',
    'author' => 'Daniel Lorenz',
    'author_email' => 'ext.cart@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'CGLcompliance' => null,
    'CGLcompliance_note' => null,
    'constraints' => [
        'depends' => [
            'typo3' => '9.3.0-9.3.99',
            'cart' => '5.0.0'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

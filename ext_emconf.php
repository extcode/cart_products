<?php

$EM_CONF['cart_products'] = [
    'title' => 'Cart - Products',
    'description' => 'Shopping Cart(s) for TYPO3 - Products',
    'category' => 'plugin',
    'version' => '5.0.2',
    'state' => 'stable',
    'author' => 'Daniel Gohlke',
    'author_email' => 'ext@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'cart' => '9.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

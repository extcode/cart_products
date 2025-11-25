<?php

$EM_CONF['cart_products'] = [
    'title' => 'Cart - Products',
    'description' => 'Shopping Cart(s) for TYPO3 - Products',
    'category' => 'plugin',
    'version' => '7.2.0',
    'state' => 'stable',
    'author' => 'Daniel Gohlke',
    'author_email' => 'ext@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'cart' => '11.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];

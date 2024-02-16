<?php

$EM_CONF['cart_products'] = [
    'title' => 'Cart - Products',
    'description' => 'Shopping Cart(s) for TYPO3 - Products',
    'category' => 'plugin',
    'version' => '4.2.1',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Daniel Gohlke',
    'author_email' => 'ext.cart@extco.de',
    'author_company' => 'extco.de UG (haftungsbeschränkt)',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'cart' => '8.0.0'
        ],
        'conflicts' => [],
        'suggests' => [
            'watchlist' => '1.0.0-1.99.99',
        ],
    ],
];

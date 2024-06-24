<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Domain\Repository\PageRepository;

return [
    'pages' => [
        0 => [
            'uid' => '1',
            'pid' => '0',
            'title' => 'Root EN',
            'doktype' => PageRepository::DOKTYPE_DEFAULT,
            'slug' => '/',
            'sorting' => '128',
            'deleted' => '0',
            'is_siteroot' => '1',
        ],
        1 => [
            'uid' => '110',
            'pid' => '100',
            'title' => 'Products',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
        ],
        2 => [
            'uid' => '111',
            'pid' => '110',
            'title' => 'Products 1',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
        ],
        3 => [
            'uid' => '112',
            'pid' => '110',
            'title' => 'Products 2',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
        ],
        4 => [
            'uid' => '113',
            'pid' => '110',
            'title' => 'Products 3',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
        ],
        5 => [
            'uid' => '120',
            'pid' => '100',
            'title' => 'Coupons',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
        ],
        6 => [
            'uid' => '130',
            'pid' => '100',
            'title' => 'Orders',
            'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
        ],
    ],
];

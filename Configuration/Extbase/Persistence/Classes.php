<?php

declare(strict_types=1);

use Extcode\CartProducts\Domain\Model\Category;
use Extcode\CartProducts\Domain\Model\TtContent;

return [
    TtContent::class => [
        'tableName' => 'tt_content',
        'properties' => [
            'altText' => [
                'fieldName' => 'altText',
            ],
            'titleText' => [
                'fieldName' => 'titleText',
            ],
            'colPos' => [
                'fieldName' => 'colPos',
            ],
            'CType' => [
                'fieldName' => 'CType',
            ],
        ],
    ],

    Category::class => [
        'tableName' => 'sys_category',
        'properties' => [
            'parentcategory' => [
                'fieldName' => 'parent',
            ],
        ],
    ],
];

<?php
declare(strict_types=1);

return [
    \Extcode\CartProducts\Domain\Model\TtContent::class => [
        'tableName' => 'tt_content',
        'properties' => [
            'altText' => [
                'fieldName' => 'altText'
            ],
            'titleText' => [
                'fieldName' => 'titleText'
            ],
            'colPos' => [
                'fieldName' => 'colPos'
            ],
            'CType' => [
                'fieldName' => 'CType'
            ],
        ],
    ],
    \Extcode\CartProducts\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
    ],
];

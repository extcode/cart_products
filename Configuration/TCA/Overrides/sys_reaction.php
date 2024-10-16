<?php

use Extcode\CartProducts\Reaction\UpdateStockReaction;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (ExtensionManagementUtility::isLoaded('typo3/cms-reactions')) {
    // Add the custom type to the type select
    ExtensionManagementUtility::addTcaSelectItem(
        'sys_reaction',
        'reaction_type',
        [
            'label' => UpdateStockReaction::getDescription(),
            'value' => UpdateStockReaction::getType(),
            'icon' => UpdateStockReaction::getIconIdentifier(),
        ]
    );

    // Type icon
    $GLOBALS['TCA']['sys_reaction']['ctrl']['typeicon_classes'][UpdateStockReaction::getType()] = UpdateStockReaction::getIconIdentifier();

    // What fields to display
    $GLOBALS['TCA']['sys_reaction']['types'][UpdateStockReaction::getType()] = [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;config,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;access',
    ];
}

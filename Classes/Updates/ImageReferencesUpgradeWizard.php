<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Updates;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('cartProducts_updateImageReferences')]
final class ImageReferencesUpgradeWizard implements UpgradeWizardInterface
{
    public const TABLE_NAME = 'sys_file_reference';
    public const IDENTIFIER = 'tx_cartproducts_domain_model_product_product';

    public function getTitle(): string
    {
        return 'Updates image references for EXT:cart_products';
    }

    public function getDescription(): string
    {
        return 'Up to TYPO3 version 11 the image references of EXT:cart_products used  the key "image" for image references in the column `fieldname` of table `sys_file_reference`. This changed with the version for TYPO3 v12 where instead the key "images" is used. This wizard updates all references.';
    }

    public function executeUpdate(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder
            ->update(self::TABLE_NAME)
            ->where(
                $queryBuilder->expr()->eq(
                    'tablenames',
                    $queryBuilder->createNamedParameter(self::IDENTIFIER, Connection::PARAM_STR)
                ),
                $queryBuilder->expr()->eq(
                    'fieldname',
                    $queryBuilder->createNamedParameter('image', Connection::PARAM_STR)
                ),
            )
            ->set('fieldname', 'images')
            ->executeStatement();

        return true;
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::TABLE_NAME);
        $queryBuilder->getRestrictions()->removeAll();
        $count = $queryBuilder->count('uid')
            ->from(self::TABLE_NAME)->where(
                $queryBuilder->expr()->eq(
                    'fieldname',
                    $queryBuilder->createNamedParameter('image', Connection::PARAM_STR)
                ),
                $queryBuilder->expr()->eq(
                    'tablenames',
                    $queryBuilder->createNamedParameter(self::IDENTIFIER, Connection::PARAM_STR)
                ),
            )->executeQuery()->fetchOne();

        return (bool)$count;
    }

    public function getPrerequisites(): array
    {
        return [];
    }
}

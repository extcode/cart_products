<?php

declare(strict_types=1);

namespace Extcode\CartProducts\Updates;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\ChattyInterface;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

/**
 * Generate slugs for empty path_segments
 */
class SlugUpdater implements UpgradeWizardInterface, ChattyInterface
{
    public const IDENTIFIER = 'cartProductsSlugUpdater';
    public const TABLE_NAME = 'tx_cartproducts_domain_model_product_product';

    protected OutputInterface $output;

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function getTitle(): string
    {
        return 'Updates slug field "path_segment" of EXT:cart_products records';
    }

    public function getDescription(): string
    {
        return 'TYPO3 includes native URL handling. Every product record has its own speaking URL path called "slug" which can be edited in TYPO3 Backend. However, it is necessary that all products have a URL pre-filled. This is done by evaluating the title.';
    }

    public function updateNecessary(): bool
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable(self::TABLE_NAME);
        $queryBuilder->getRestrictions()->removeAll();
        $elementCount = $queryBuilder->count('uid')
            ->from(self::TABLE_NAME)->where($queryBuilder->expr()->or($queryBuilder->expr()->eq('path_segment', $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)), $queryBuilder->expr()->isNull('path_segment')))->executeQuery()->fetchFirstColumn();

        return (bool)$elementCount;
    }

    public function executeUpdate(): bool
    {
        $slugHelper = GeneralUtility::makeInstance(
            SlugHelper::class,
            self::TABLE_NAME,
            'path_segment',
            $GLOBALS['TCA'][self::TABLE_NAME]['columns']['path_segment']['config']
        );

        $connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable(self::TABLE_NAME);
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder->getRestrictions()->removeAll();
        $statement = $queryBuilder->select('uid', 'title')
            ->from(self::TABLE_NAME)->where($queryBuilder->expr()->or($queryBuilder->expr()->eq('path_segment', $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)), $queryBuilder->expr()->isNull('path_segment')))->executeQuery();
        while ($record = $statement->fetchAssociative()) {
            $queryBuilder = $connection->createQueryBuilder();
            $queryBuilder->update(self::TABLE_NAME)
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                    )
                )
                ->set('path_segment', $slugHelper->sanitize((string)$record['title']));
            $queryBuilder->getSQL();
            $queryBuilder->execute();
        }

        return true;
    }

    /**
     * @return string[]
     */
    public function getPrerequisites(): array
    {
        return [];
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }
}

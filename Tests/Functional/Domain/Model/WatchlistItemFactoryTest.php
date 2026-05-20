<?php

namespace Extcode\CartProducts\Tests\Functional\Domain\Model;

use Codappix\Typo3PhpDatasets\TestingFramework;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;
use Extcode\CartProducts\Domain\Model\WatchlistItemFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(WatchlistItemFactory::class)]
class WatchlistItemFactoryTest extends FunctionalTestCase
{
    use TestingFramework;

    private WatchlistItemFactory $watchlistItemFactory;

    public function setUp(): void
    {
        $this->testExtensionsToLoad[] = 'extcode/cart';
        $this->testExtensionsToLoad[] = 'extcode/cart-products';

        $this->coreExtensionsToLoad[] = 'typo3/cms-reactions';

        parent::setUp();

        $GLOBALS['TYPO3_REQUEST'] = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE);

        $this->watchlistItemFactory = GeneralUtility::makeInstance(
            WatchlistItemFactory::class,
            GeneralUtility::makeInstance(
                ProductRepository::class,
                GeneralUtility::makeInstance(
                    ConnectionPool::class
                )
            )
        );

        $this->importPHPDataSet(__DIR__ . '/../../Fixtures/Pages.php');
        $this->importPHPDataSet(__DIR__ . '/../../Fixtures/Products.php');
    }

    #[Test]
    public function returnsNullIfProductHasNoImage(): void
    {
        $watchlistItem = $this->watchlistItemFactory->createFromIdentifier('1-1');

        self::assertNull(
            $watchlistItem->getFileReference()
        );
    }

    #[Test]
    public function returnsUidOfFileReferenceIfProductHasOnlyOneImage(): void
    {
        $this->importPhpDataSet(__DIR__ . '/../DoctrineRepository/Product/Fixtures/OneImageFileReference.php');

        $this
            ->getConnectionPool()
            ->getConnectionForTable('tx_cartproducts_domain_model_product_product')
            ->update(
                'tx_cartproducts_domain_model_product_product',
                [
                    'images' => 1,
                ],
                [
                    'uid' => 1,
                ]
            )
        ;

        $watchlistItem = $this->watchlistItemFactory->createFromIdentifier('1-1');

        self::assertSame(
            1,
            $watchlistItem->getFileReference()
        );
    }

    #[Test]
    public function returnsNullIfProductHasOnlyOneDeaktivatedImage(): void
    {
        $this->importPhpDataSet(__DIR__ . '/../DoctrineRepository/Product/Fixtures/OneImageFileReference.php');

        $this
            ->getConnectionPool()
            ->getConnectionForTable('tx_cartproducts_domain_model_product_product')
            ->update(
                'tx_cartproducts_domain_model_product_product',
                [
                    'images' => 1,
                ],
                [
                    'uid' => 1,
                ]
            )
        ;

        $this
            ->getConnectionPool()
            ->getConnectionForTable('sys_file_reference')
            ->update(
                'sys_file_reference',
                [
                    'deleted' => 1,
                ],
                [
                    'uid' => 1,
                ]
            )
        ;

        $watchlistItem = $this->watchlistItemFactory->createFromIdentifier('1-1');

        self::assertNull(
            $watchlistItem->getFileReference()
        );
    }
}

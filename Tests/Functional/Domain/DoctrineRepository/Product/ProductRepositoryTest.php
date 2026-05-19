<?php

namespace Extcode\CartProducts\Tests\Functional\Domain\DoctrineRepository\Product;

use Codappix\Typo3PhpDatasets\TestingFramework;
use Extcode\CartProducts\Domain\DoctrineRepository\Product\ProductRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(ProductRepository::class)]
class ProductRepositoryTest extends FunctionalTestCase
{
    use TestingFramework;

    protected ProductRepository $productRepository;

    public function setUp(): void
    {
        $this->testExtensionsToLoad[] = 'extcode/cart';
        $this->testExtensionsToLoad[] = 'extcode/cart-products';

        $this->coreExtensionsToLoad[] = 'typo3/cms-reactions';

        parent::setUp();

        $GLOBALS['TYPO3_REQUEST'] = (new ServerRequest())
            ->withAttribute('applicationType', SystemEnvironmentBuilder::REQUESTTYPE_BE);

        $this->productRepository = GeneralUtility::makeInstance(
            ProductRepository::class,
            GeneralUtility::makeInstance(
                ConnectionPool::class
            )
        );

        $this->importPHPDataSet(__DIR__ . '/../../../Fixtures/Pages.php');
        $this->importPHPDataSet(__DIR__ . '/../../../Fixtures/Products.php');
    }

    #[Test]
    public function returnsFalseIfProductHasNoImage(): void
    {
        self::assertFalse(
            $this->productRepository->findFirstProductImageUid(1)
        );
    }

    #[Test]
    public function returnsUidOfImageIfProductHasOnlyOneImage(): void
    {
        $this->importPhpDataSet(__DIR__ . '/Fixtures/OneImageFileReference.php');

        self::assertSame(
            1,
            $this->productRepository->findFirstProductImageUid(1)
        );
    }

    #[Test]
    public function returnsFirstUidOfImageIfProductHasMoreThanOneImage(): void
    {
        $this->importPhpDataSet(__DIR__ . '/Fixtures/TwoImageFileReference.php');

        self::assertSame(
            5,
            $this->productRepository->findFirstProductImageUid(1)
        );
    }

    #[Test]
    public function returnsSecondUidOfImageIfProductHasMoreThanOneImageAndRespectsSorting(): void
    {
        $this->importPhpDataSet(__DIR__ . '/Fixtures/TwoImageFileReference.php');

        $this
            ->getConnectionPool()
            ->getConnectionForTable('sys_file_reference')
            ->update(
                'sys_file_reference',
                [
                    'sorting_foreign' => 128,
                ],
                [
                    'uid' => 5,
                ]
            )
        ;
        $this
            ->getConnectionPool()
            ->getConnectionForTable('sys_file_reference')
            ->update(
                'sys_file_reference',
                [
                    'sorting_foreign' => 16,
                ],
                [
                    'uid' => 16,
                ]
            )
        ;

        self::assertSame(
            16,
            $this->productRepository->findFirstProductImageUid(1)
        );
    }

    #[Test]
    public function returnsSecondUidOfImageIfProductHasMoreThanOneImageAndFirstIsDeleted(): void
    {
        $this->importPhpDataSet(__DIR__ . '/Fixtures/TwoImageFileReference.php');

        $this
            ->getConnectionPool()
            ->getConnectionForTable('sys_file_reference')
            ->update(
                'sys_file_reference',
                [
                    'deleted' => 1,
                ],
                [
                    'uid' => 5,
                ]
            )
        ;

        self::assertSame(
            16,
            $this->productRepository->findFirstProductImageUid(1)
        );
    }

    #[Test]
    public function returnsSecondUidOfImageIfProductHasMoreThanOneImageAndFirstIsHidden(): void
    {
        $this->importPhpDataSet(__DIR__ . '/Fixtures/TwoImageFileReference.php');

        $this
            ->getConnectionPool()
            ->getConnectionForTable('sys_file_reference')
            ->update(
                'sys_file_reference',
                [
                    'hidden' => 1,
                ],
                [
                    'uid' => 5,
                ]
            )
        ;

        self::assertSame(
            16,
            $this->productRepository->findFirstProductImageUid(1)
        );
    }
}

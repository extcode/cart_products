<?php

namespace Extcode\CartProducts\Tests\Functional\Domain\Repository\Product;

use Codappix\Typo3PhpDatasets\TestingFramework;
use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Core\SystemEnvironmentBuilder;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

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

        $this->productRepository = GeneralUtility::makeInstance(ProductRepository::class);

        $this->importPHPDataSet(__DIR__ . '/../../../Fixtures/Pages.php');
        $this->importPHPDataSet(__DIR__ . '/../../../Fixtures/Products.php');
    }

    #[Test]
    public function findDemandedWithGivenSkuReturnsProducts(): void
    {
        $querySettings = GeneralUtility::makeInstance(QuerySettingsInterface::class);
        $querySettings->setStoragePageIds([110]);
        $this->productRepository->setDefaultQuerySettings($querySettings);

        $productDemand = GeneralUtility::makeInstance(ProductDemand::class);
        $productDemand->setSku('first');

        $products = $this->productRepository->findDemanded($productDemand);

        self::assertCount(
            1,
            $products
        );
    }

    #[Test]
    public function findDemandedWithGivenTitleReturnsProducts(): void
    {
        $querySettings = GeneralUtility::makeInstance(QuerySettingsInterface::class);
        $querySettings->setStoragePageIds([110]);
        $this->productRepository->setDefaultQuerySettings($querySettings);

        $productDemand = GeneralUtility::makeInstance(ProductDemand::class);
        $productDemand->setTitle('First');

        $products = $this->productRepository->findDemanded($productDemand);

        self::assertCount(
            1,
            $products
        );

        $productDemand->setTitle('Product');

        $products = $this->productRepository->findDemanded($productDemand);

        self::assertCount(
            3,
            $products
        );
    }

    #[Test]
    public function findByUidsDoesNotRespectStoragePid(): void
    {
        $products = $this->productRepository->findByUids('3,1,2,5,4');

        self::assertCount(
            5,
            $products
        );

        //product 6 and 7 are hidden or deleted
        $products = $this->productRepository->findByUids('3,1,2,5,4,6,7');

        self::assertCount(
            5,
            $products
        );
    }

    #[Test]
    public function findByUidsReturnsCorrectOrder(): void
    {
        $listOfProductIds = [3, 1, 2, 5, 4];
        $products = $this->productRepository->findByUids(implode(',', $listOfProductIds));

        foreach ($products as $key => $product) {
            self::assertSame(
                $listOfProductIds[$key],
                $product->getUid()
            );
        }
    }
}

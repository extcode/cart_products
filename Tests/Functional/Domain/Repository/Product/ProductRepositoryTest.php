<?php

namespace Extcode\CartProducts\Tests\Functional\Domain\Repository\Product;

use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class ProductRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/cart',
        'typo3conf/ext/cart_products',
    ];

    protected ProductRepository $productRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = GeneralUtility::makeInstance(ProductRepository::class);

        $fixturePath = __DIR__ . '/../../../Fixtures/';
        $this->importCSVDataSet($fixturePath . 'pages.csv');
        $this->importCSVDataSet($fixturePath . 'tx_cartproducts_domain_model_product_product.csv');
    }

    /**
     * @test
     */
    public function findDemandedWithGivenSkuReturnsProducts()
    {
        $_GET['id'] = 110;

        $productDemand = GeneralUtility::makeInstance(ProductDemand::class);
        $productDemand->setSku('first');

        $products = $this->productRepository->findDemanded($productDemand);

        self::assertCount(
            1,
            $products
        );
    }

    /**
     * @test
     */
    public function findDemandedWithGivenTitleReturnsProducts()
    {
        $_GET['id'] = 110;

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

    /**
     * @test
     */
    public function findByUidsDoesNotRespectStoragePid()
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

    /**
     * @test
     */
    public function findByUidsReturnsCorrectOrder()
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

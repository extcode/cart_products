<?php

namespace Extcode\CartProducts\Tests\Functional\Domain\Repository\Product;

use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class ProductRepositoryTest extends FunctionalTestCase
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var array
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/cart',
        'typo3conf/ext/cart_products',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->productRepository = GeneralUtility::makeInstance(ProductRepository::class);

        $fixturePath = ORIGINAL_ROOT . 'typo3conf/ext/cart_products/Tests/Functional/Fixtures/';
        $this->importDataSet($fixturePath . 'pages.xml');
        $this->importDataSet($fixturePath . 'tx_cartproducts_domain_model_product_product.xml');
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

        $this->assertCount(
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

        $this->assertCount(
            1,
            $products
        );

        $productDemand->setTitle('Product');

        $products = $this->productRepository->findDemanded($productDemand);

        $this->assertCount(
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

        $this->assertCount(
            5,
            $products
        );

        //product 6 and 7 are hidden or deleted
        $products = $this->productRepository->findByUids('3,1,2,5,4,6,7');

        $this->assertCount(
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
            $this->assertSame(
                $listOfProductIds[$key],
                $product->getUid()
            );
        }
    }
}

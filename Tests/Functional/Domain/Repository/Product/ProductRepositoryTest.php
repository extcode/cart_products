<?php

namespace Extcode\CartProducts\Tests\Domain\Repository\Product;

use Extcode\CartProducts\Domain\Model\Dto\Product\ProductDemand;
use Extcode\CartProducts\Domain\Repository\Product\ProductRepository;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProductRepositoryTest extends FunctionalTestCase
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

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

    public function setUp()
    {
        parent::setUp();

        $this->objectManager = GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );
        $this->productRepository = $this->objectManager->get(ProductRepository::class);

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

        $productDemand = $this->objectManager->get(ProductDemand::class);
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

        $productDemand = $this->objectManager->get(ProductDemand::class);
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

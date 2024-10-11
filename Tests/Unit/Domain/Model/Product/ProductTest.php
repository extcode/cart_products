<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\BeVariant;
use Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Model\Product\SpecialPrice;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ProductTest extends UnitTestCase
{
    /**
     * @var Product
     */
    protected $product;

    protected function setUp(): void
    {
        $this->product = new Product();
    }

    protected function tearDown(): void
    {
        unset($this->product);
    }

    /**
     * DataProvider for best Special Price calculation
     *
     * @return array
     */
    public static function bestSpecialPriceProvider()
    {
        return [
            [100.0, 80.0, 75.0, 90.0, 75.0],
            [100.0, 75.0, 90.0, 50.0, 50.0],
            [100.0, 80.0, 60.0, 80.0, 60.0],
        ];
    }

    /**
     * DataProvider for best Special Price Discount calculation
     *
     * @return array
     */
    public static function bestSpecialPriceDiscountProvider()
    {
        return [
            [100.0, 80.0, 75.0, 90.0, 25.0],
            [100.0, 75.0, 90.0, 50.0, 50.0],
            [100.0, 80.0, 60.0, 80.0, 40.0],
        ];
    }

    /**
     * @test
     */
    public function getProductTypeReturnsInitialValueForProductType(): void
    {
        self::assertSame(
            'simple',
            $this->product->getProductType()
        );
    }

    /**
     * @test
     */
    public function setProductTypeSetsProductType(): void
    {
        $this->product->setProductType('configurable');

        self::assertSame(
            'configurable',
            $this->product->getProductType()
        );
    }

    /**
     * @test
     */
    public function getTeaserReturnsInitialValueForTeaser(): void
    {
        self::assertSame(
            '',
            $this->product->getTeaser()
        );
    }

    /**
     * @test
     */
    public function setTeaserForStringSetsTeaser(): void
    {
        $this->product->setTeaser('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->product->getTeaser()
        );
    }

    /**
     * @test
     */
    public function getMinNumberInOrderInitiallyReturnsMinNumberInOrder(): void
    {
        self::assertSame(
            0,
            $this->product->getMinNumberInOrder()
        );
    }

    /**
     * @test
     */
    public function setNegativeMinNumberThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $minNumber = -10;

        $this->product->setMinNumberInOrder($minNumber);
    }

    /**
     * @test
     */
    public function setMinNumberGreaterThanMaxNumberThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $minNumber = 10;

        $this->product->setMinNumberInOrder($minNumber);
    }

    /**
     * @test
     */
    public function setMinNumberInOrderSetsMinNumberInOrder(): void
    {
        $minNumber = 10;

        $this->product->setMaxNumberInOrder($minNumber);
        $this->product->setMinNumberInOrder($minNumber);

        self::assertSame(
            $minNumber,
            $this->product->getMinNumberInOrder()
        );
    }

    /**
     * @test
     */
    public function getMaxNumberInOrderInitiallyReturnsMaxNumberInOrder(): void
    {
        self::assertSame(
            0,
            $this->product->getMaxNumberInOrder()
        );
    }

    /**
     * @test
     */
    public function setNegativeMaxNumberThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $maxNumber = -10;

        $this->product->setMaxNumberInOrder($maxNumber);
    }

    /**
     * @test
     */
    public function setMaxNumberInOrderSetsMaxNumberInOrder(): void
    {
        $maxNumber = 10;

        $this->product->setMaxNumberInOrder($maxNumber);

        self::assertSame(
            $maxNumber,
            $this->product->getMaxNumberInOrder()
        );
    }

    /**
     * @test
     */
    public function setMaxNumberLesserThanMinNumberThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $minNumber = 10;
        $maxNumber = 1;

        $this->product->setMaxNumberInOrder($minNumber);
        $this->product->setMinNumberInOrder($minNumber);

        $this->product->setMaxNumberInOrder($maxNumber);
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForFloat(): void
    {
        self::assertSame(
            0.0,
            $this->product->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceSetsPrice(): void
    {
        $this->product->setPrice(3.14159265);

        self::assertSame(
            3.14159265,
            $this->product->getPrice()
        );
    }

    /**
     * @test
     */
    public function getSpecialPricesInitiallyIsEmpty(): void
    {
        self::assertEmpty(
            $this->product->getSpecialPrices()
        );
    }

    /**
     * @test
     */
    public function setSpecialPricesSetsSpecialPrices(): void
    {
        $price = 10.00;

        $specialPrice = new SpecialPrice();
        $specialPrice->setPrice($price);

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($specialPrice);

        $this->product->setSpecialPrices($objectStorage);

        self::assertContains(
            $specialPrice,
            $this->product->getSpecialPrices()
        );
    }

    /**
     * @test
     */
    public function addSpecialPriceAddsSpecialPrice(): void
    {
        $price = 10.00;

        $specialPrice = new SpecialPrice();
        $specialPrice->setPrice($price);

        $this->product->addSpecialPrice($specialPrice);

        self::assertContains(
            $specialPrice,
            $this->product->getSpecialPrices()
        );
    }

    /**
     * @test
     */
    public function removeSpecialPriceRemovesSpecialPrice(): void
    {
        $price = 10.00;

        $specialPrice = new SpecialPrice();
        $specialPrice->setPrice($price);

        $this->product->addSpecialPrice($specialPrice);
        $this->product->removeSpecialPrice($specialPrice);

        self::assertEmpty(
            $this->product->getSpecialPrices()
        );
    }

    /**
     * @test
     */
    public function getBestSpecialPriceDiscountForEmptySpecialPriceReturnsDiscount(): void
    {
        $price = 10.00;

        $product = new Product();
        $product->setPrice($price);

        self::assertSame(
            0.0,
            $product->getBestSpecialPriceDiscount()
        );
    }

    /**
     * @test
     * @dataProvider bestSpecialPriceProvider
     */
    public function getBestSpecialPriceForGivenSpecialPricesReturnsBestSpecialPrice(
        $price,
        $special1,
        $special2,
        $special3,
        $expectedBestSpecialPrice
    ): void {
        $product = new Product();
        $product->setPrice($price);

        $specialPrice1 = new SpecialPrice();
        $specialPrice1->setPrice($special1);
        $product->addSpecialPrice($specialPrice1);

        $specialPrice2 = new SpecialPrice();
        $specialPrice2->setPrice($special2);
        $product->addSpecialPrice($specialPrice2);

        $specialPrice3 = new SpecialPrice();
        $specialPrice3->setPrice($special3);
        $product->addSpecialPrice($specialPrice3);

        self::assertSame(
            $expectedBestSpecialPrice,
            $product->getBestSpecialPrice()
        );
    }

    /**
     * @test
     */
    public function getBestSpecialPriceDiscountForGivenSpecialPriceReturnsPercentageDiscount(): void
    {
        $price = 10.0;
        $porductSpecialPrice = 9.0;

        $product = new Product();
        $product->setPrice($price);

        $specialPrice = new SpecialPrice();
        $specialPrice->setPrice($porductSpecialPrice);

        $product->addSpecialPrice($specialPrice);

        self::assertSame(
            10.0,
            $product->getBestSpecialPricePercentageDiscount()
        );
    }

    /**
     * @test
     * @dataProvider bestSpecialPriceDiscountProvider
     */
    public function getBestSpecialPriceDiscountForGivenSpecialPricesReturnsBestPercentageDiscount(
        $price,
        $special1,
        $special2,
        $special3,
        $expectedBestSpecialPriceDiscount
    ): void {
        $product = new Product();
        $product->setPrice($price);

        $specialPrice1 = new SpecialPrice();
        $specialPrice1->setPrice($special1);
        $product->addSpecialPrice($specialPrice1);

        $specialPrice2 = new SpecialPrice();
        $specialPrice2->setPrice($special2);
        $product->addSpecialPrice($specialPrice2);

        $specialPrice3 = new SpecialPrice();
        $specialPrice3->setPrice($special3);
        $product->addSpecialPrice($specialPrice3);

        self::assertSame(
            $expectedBestSpecialPriceDiscount,
            $product->getBestSpecialPriceDiscount()
        );
    }

    /**
     * @test
     */
    public function getStockWithoutHandleStockInitiallyReturnsIntMax(): void
    {
        $product = new Product();

        self::assertSame(
            PHP_INT_MAX,
            $product->getStock()
        );
    }

    /**
     * @test
     */
    public function getStockWithHandleStockInitiallyReturnsZero(): void
    {
        $product = new Product();
        $product->setHandleStock(true);

        self::assertSame(
            0,
            $product->getStock()
        );
    }

    /**
     * @test
     */
    public function setStockWithHandleStockSetsStock(): void
    {
        $stock = 10;

        $product = new Product();
        $product->setStock($stock);
        $product->setHandleStock(true);

        self::assertSame(
            $stock,
            $product->getStock()
        );

        $product->setHandleStock(false);

        self::assertSame(
            PHP_INT_MAX,
            $product->getStock()
        );
    }

    /**
     * @test
     */
    public function addToStockAddsANumberOfProductsToStock(): void
    {
        $numberOfProducts = 10;

        $product = new Product();
        $product->setHandleStock(true);
        $product->addToStock($numberOfProducts);

        self::assertSame(
            $numberOfProducts,
            $product->getStock()
        );
    }

    /**
     * @test
     */
    public function removeFromStockAddsRemovesANumberOfProductsFromStock(): void
    {
        $stock = 100;
        $numberOfProducts = 10;

        $product = new Product();
        $product->setHandleStock(true);
        $product->setStock($stock);
        $product->removeFromStock($numberOfProducts);

        self::assertSame(
            ($stock - $numberOfProducts),
            $product->getStock()
        );
    }

    /**
     * @test
     */
    public function handleStockInitiallyReturnsFalse(): void
    {
        $product = new Product();

        self::assertFalse(
            $product->isHandleStock()
        );
    }

    /**
     * @test
     */
    public function setHandleStockSetsHandleStock(): void
    {
        $product = new Product();
        $product->setHandleStock(true);

        self::assertTrue(
            $product->isHandleStock()
        );
    }

    /**
     * @test
     */
    public function isAvailableInitiallyReturnsTrue(): void
    {
        $product = new Product();

        self::assertTrue(
            $product->getIsAvailable()
        );
    }

    /**
     * @test
     */
    public function isAvailableWithHandleStockIsEnabledAndEmptyStockReturnsFalse(): void
    {
        $product = new Product();
        $product->setHandleStock(true);

        self::assertFalse(
            $product->getIsAvailable()
        );
    }

    /**
     * @test
     */
    public function isAvailableWithHandleStockIsEnabledAndNotEmptyStockReturnsTrue(): void
    {
        $product = new Product();
        $product->setStock(10);
        $product->setHandleStock(true);

        self::assertTrue(
            $product->getIsAvailable()
        );
    }

    /**
     * @test
     */
    public function isAvailableWithHandleStockAndHandleStockInVariantsIsEnabledAndNoBackendVariantsConfiguredReturnsFalse(): void
    {
        $product = new Product();
        $product->setStock(10);
        $product->setHandleStock(true);
        $product->setHandleStockInVariants(true);

        self::assertFalse(
            $product->getIsAvailable()
        );
    }

    /**
     * @test
     */
    public function isAvailableWithHandleStockAndHandleStockInVariantsIsEnabledAndBackendVariantConfiguredIsNotAvailableReturnsFalse(): void
    {
        $productBackendVariant = $this->createMock(
            BeVariant::class
        );
        $productBackendVariant->expects(self::any())->method('getIsAvailable')->willReturn(false);

        $product = new Product();
        $product->addBeVariant($productBackendVariant);
        $product->setStock(10);
        $product->setHandleStock(true);
        $product->setHandleStockInVariants(true);

        self::assertFalse(
            $product->getIsAvailable()
        );
    }

    /**
     * @test
     */
    public function isAvailableWithHandleStockAndHandleStockInVariantsIsEnabledAndBackendVariantConfiguredIsAvailableReturnsFalse(): void
    {
        $productBackendVariant = $this->createMock(
            BeVariant::class
        );
        $productBackendVariant->expects(self::any())->method('getIsAvailable')->willReturn(true);

        $product = new Product();
        $product->addBeVariant($productBackendVariant);
        $product->setStock(10);
        $product->setHandleStock(true);
        $product->setHandleStockInVariants(true);

        self::assertTrue(
            $product->getIsAvailable()
        );
    }

    /**
     * @test
     */
    public function getTaxClassIdInitiallyReturnsTaxClassId(): void
    {
        self::assertSame(
            1,
            $this->product->getTaxClassId()
        );
    }

    /**
     * @test
     */
    public function setTaxClassIdSetsTaxClassId(): void
    {
        $taxClassId = 2;

        $this->product->setTaxClassId($taxClassId);

        self::assertSame(
            $taxClassId,
            $this->product->getTaxClassId()
        );
    }

    /**
     * @test
     */
    public function getBeVariantAttribute1InitiallyIsNull(): void
    {
        self::assertNull(
            $this->product->getBeVariantAttribute1()
        );
    }

    /**
     * @test
     */
    public function setBeVariantAttribute1SetsBeVariantAttribute1(): void
    {
        $beVariantAttribute = new BeVariantAttribute();

        $this->product->setBeVariantAttribute1($beVariantAttribute);

        self::assertSame(
            $beVariantAttribute,
            $this->product->getBeVariantAttribute1()
        );
    }

    /**
     * @test
     */
    public function getBeVariantAttribute2InitiallyIsNull(): void
    {
        self::assertNull(
            $this->product->getBeVariantAttribute2()
        );
    }

    /**
     * @test
     */
    public function setBeVariantAttribute2SetsBeVariantAttribute2(): void
    {
        $beVariantAttribute = new BeVariantAttribute();

        $this->product->setBeVariantAttribute2($beVariantAttribute);

        self::assertSame(
            $beVariantAttribute,
            $this->product->getBeVariantAttribute2()
        );
    }

    /**
     * @test
     */
    public function getBeVariantAttribute3InitiallyIsNull(): void
    {
        self::assertNull(
            $this->product->getBeVariantAttribute3()
        );
    }

    /**
     * @test
     */
    public function setBeVariantAttribute3SetsBeVariantAttribute3(): void
    {
        $beVariantAttribute = new BeVariantAttribute();

        $this->product->setBeVariantAttribute3($beVariantAttribute);

        self::assertSame(
            $beVariantAttribute,
            $this->product->getBeVariantAttribute3()
        );
    }

    /**
     * @test
     */
    public function getVariantsInitiallyIsEmpty(): void
    {
        self::assertEmpty(
            $this->product->getBeVariants()
        );
    }

    /**
     * @test
     */
    public function setVariantsSetsVariants(): void
    {
        $variant = new BeVariant();

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($variant);

        $this->product->setBeVariants($objectStorage);

        self::assertContains(
            $variant,
            $this->product->getBeVariants()
        );
    }

    /**
     * @test
     */
    public function addVariantAddsVariant(): void
    {
        $variant = new BeVariant();

        $this->product->addBeVariant($variant);

        self::assertContains(
            $variant,
            $this->product->getBeVariants()
        );
    }

    /**
     * @test
     */
    public function removeVariantRemovesVariant(): void
    {
        $variant = new BeVariant();

        $this->product->addBeVariant($variant);
        $this->product->removeBeVariant($variant);

        self::assertEmpty(
            $this->product->getBeVariants()
        );
    }
}

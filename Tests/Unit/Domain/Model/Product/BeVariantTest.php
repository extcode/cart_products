<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\BeVariant;
use Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption;
use Extcode\CartProducts\Domain\Model\Product\Product;
use Extcode\CartProducts\Domain\Model\Product\SpecialPrice;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BeVariantTest extends UnitTestCase
{
    /**
     * @var BeVariant
     */
    protected $beVariant;

    public function setUp(): void
    {
        $this->beVariant = new BeVariant();
    }

    public function tearDown(): void
    {
        unset($this->beVariant);
    }

    #[Test]
    public function getProductInitiallyReturnsNull(): void
    {
        self::assertNull(
            $this->beVariant->getProduct()
        );
    }

    #[Test]
    public function setProductSetsProduct(): void
    {
        $product = new Product();
        $this->beVariant->setProduct($product);

        self::assertSame(
            $product,
            $this->beVariant->getProduct()
        );
    }

    #[Test]
    public function getBeVariantAttributeOption1InitiallyIsNull(): void
    {
        self::assertNull(
            $this->beVariant->getBeVariantAttributeOption1()
        );
    }

    #[Test]
    public function setBeVariantAttributeOption1SetsBeVariantAttributeOption1(): void
    {
        $beVariantAttributeOption = new BeVariantAttributeOption();

        $this->beVariant->setBeVariantAttributeOption1($beVariantAttributeOption);

        self::assertSame(
            $beVariantAttributeOption,
            $this->beVariant->getBeVariantAttributeOption1()
        );
    }

    #[Test]
    public function getBeVariantAttributeOption2InitiallyIsNull(): void
    {
        self::assertNull(
            $this->beVariant->getBeVariantAttributeOption2()
        );
    }

    #[Test]
    public function setBeVariantAttributeOption2SetsBeVariantAttributeOption2(): void
    {
        $beVariantAttributeOption = new BeVariantAttributeOption();

        $this->beVariant->setBeVariantAttributeOption2($beVariantAttributeOption);

        self::assertSame(
            $beVariantAttributeOption,
            $this->beVariant->getBeVariantAttributeOption2()
        );
    }

    #[Test]
    public function getBeVariantAttributeOption3InitiallyIsNull(): void
    {
        self::assertNull(
            $this->beVariant->getBeVariantAttributeOption3()
        );
    }

    #[Test]
    public function setBeVariantAttributeOption3SetsBeVariantAttributeOption3(): void
    {
        $beVariantAttributeOption = new BeVariantAttributeOption();

        $this->beVariant->setBeVariantAttributeOption3($beVariantAttributeOption);

        self::assertSame(
            $beVariantAttributeOption,
            $this->beVariant->getBeVariantAttributeOption3()
        );
    }

    #[Test]
    public function getPriceInitiallyReturnsZero(): void
    {
        $price = 0.0;

        self::assertSame(
            $price,
            $this->beVariant->getPrice()
        );
    }

    #[Test]
    public function setPriceSetsPrice(): void
    {
        $price = 100.0;

        $this->beVariant->setPrice($price);

        self::assertSame(
            $price,
            $this->beVariant->getPrice()
        );
    }

    #[Test]
    public function getSpecialPricesInitiallyReturnsEmptyObjectStorage(): void
    {
        self::assertInstanceOf(
            ObjectStorage::class,
            $this->beVariant->getSpecialPrices()
        );
    }

    #[Test]
    public function addSpecialPriceAddsSpecialPrice(): void
    {
        $specialPrice = new SpecialPrice();

        $this->beVariant->addSpecialPrice($specialPrice);

        self::assertSame(
            $specialPrice,
            $this->beVariant->getBestSpecialPrice()
        );
    }

    #[Test]
    public function getBestSpecialPriceWithOneSpecialPriceReturnsSpecialPrice(): void
    {
        $specialPrice = new SpecialPrice();

        $this->beVariant->addSpecialPrice($specialPrice);

        self::assertSame(
            $specialPrice,
            $this->beVariant->getBestSpecialPrice()
        );
    }

    /**
     * DataProvider for Best Special Price
     *
     * @return array
     */
    public static function bestSpecialPriceProvider()
    {
        return [
            [0, 50.0, 100.0, 150.0, 1],
            [0, 100.0, 50.0, 150.0, 2],
            [0, 100.0, 150.0, 50.0, 3],
            [1, 50.0, 100.0, 150.0, 1],
            [1, 100.0, 50.0, 150.0, 2],
            [1, 100.0, 150.0, 50.0, 3],
            [2, 150.0, 50.0, 100.0, 1],
            [2, 50.0, 150.0, 100.0, 2],
            [2, 100.0, 50.0, 150.0, 3],
            [3, 150.0, 50.0, 100.0, 1],
            [3, 50.0, 150.0, 100.0, 2],
            [3, 100.0, 50.0, 150.0, 3],
            [4, 50.0, 100.0, 150.0, 1],
            [4, 100.0, 50.0, 150.0, 2],
            [4, 100.0, 150.0, 50.0, 3],
            [5, 50.0, 100.0, 150.0, 1],
            [5, 100.0, 50.0, 150.0, 2],
            [5, 100.0, 150.0, 50.0, 3],
        ];
    }

    #[DataProvider('bestSpecialPriceProvider')]
    #[Test]
    public function getBestSpecialPriceWithMoreSpecialPricesReturnsBestSpecialPrice(
        $priceCalcMethod,
        $priceForSpecialPrice1,
        $priceForSpecialPrice2,
        $priceForSpecialPrice3,
        $expectedBestSpecialPrice
    ): void {
        $this->beVariant->setPriceCalcMethod($priceCalcMethod);

        $specialPrice1 = new SpecialPrice();
        $specialPrice1->setPrice($priceForSpecialPrice1);
        $specialPrice2 = new SpecialPrice();
        $specialPrice2->setPrice($priceForSpecialPrice2);
        $specialPrice3 = new SpecialPrice();
        $specialPrice3->setPrice($priceForSpecialPrice3);

        $this->beVariant->addSpecialPrice($specialPrice1);
        $this->beVariant->addSpecialPrice($specialPrice2);
        $this->beVariant->addSpecialPrice($specialPrice3);

        $specialPrices = [
            1 => $specialPrice1,
            2 => $specialPrice2,
            3 => $specialPrice3,
        ];

        self::assertSame(
            $specialPrices[$expectedBestSpecialPrice],
            $this->beVariant->getBestSpecialPrice()
        );
    }

    #[Test]
    public function getBestPriceInitiallyReturnsPrice(): void
    {
        $price = 100.0;

        $this->beVariant->setPrice($price);

        self::assertSame(
            $price,
            $this->beVariant->getBestPrice()
        );
    }

    /**
     * DataProvider for Best Price
     *
     * @return array
     */
    public static function bestPriceProvider()
    {
        return [
            [0, 100.0, 50.0, 50.0],
            [0, 100.0, 150.0, 100.0],
            [1, 100.0, 50.0, 50.0],
            [1, 100.0, 150.0, 100.0],
            [2, 100.0, 50.0, 100.0],
            [2, 100.0, 150.0, 150.0],
            [3, 100.0, 50.0, 100.0],
            [3, 100.0, 150.0, 150.0],
            [4, 100.0, 50.0, 50.0],
            [4, 100.0, 150.0, 100.0],
            [5, 100.0, 50.0, 50.0],
            [5, 100.0, 150.0, 100.0],
        ];
    }

    #[DataProvider('bestPriceProvider')]
    #[Test]
    public function getBestPriceWithSpecialPriceAndDifferentPriceCalcMethodsReturnsBestSpecialPrice(
        $priceCalcMethod,
        $price,
        $specialPrice,
        $expectedBestPrice
    ): void {
        $specialPriceObj = $this->createMock(
            SpecialPrice::class
        );
        $specialPriceObj->expects(self::any())->method('getPrice')->willReturn($specialPrice);

        $this->beVariant->setPrice($price);
        $this->beVariant->setPriceCalcMethod($priceCalcMethod);
        $this->beVariant->addSpecialPrice($specialPriceObj);

        self::assertSame(
            $expectedBestPrice,
            $this->beVariant->getBestPrice()
        );
    }

    /**
     * DataProvider for Best Price Calculated
     *
     * @return array
     */
    public static function bestPriceCalculatedProvider()
    {
        return [
            [0, 500.0, 400.0, 350.0, 500.0],
            [0, 500.0, 400.0, 450.0, 500.0],
            [1, 500.0, 400.0, 350.0, 350.0],
            [1, 500.0, 400.0, 450.0, 400.0],
            [2, 500.0, 20.0, 15.0, 480.0],
            [2, 500.0, 20.0, 25.0, 475.0],
            [3, 500.0, 20.0, 15.0, 400.0],
            [3, 500.0, 20.0, 25.0, 375.0],
            [4, 500.0, 20.0, 15.0, 515.0],
            [4, 500.0, 20.0, 25.0, 520.0],
            [5, 500.0, 20.0, 15.0, 575.0],
            [5, 500.0, 20.0, 25.0, 600.0],
        ];
    }

    #[DataProvider('bestPriceCalculatedProvider')]
    #[Test]
    public function getBestPriceCalculatedWithPriceCalcMethod0ReturnsPrice(
        $priceCalcMethod,
        $productPrice,
        $price,
        $specialPrice,
        $expectedBestPrice
    ): void {
        $specialPriceObj = $this->createMock(
            SpecialPrice::class
        );
        $specialPriceObj->expects(self::any())->method('getPrice')->willReturn($specialPrice);

        $this->beVariant->setPrice($price);
        $this->beVariant->setPriceCalcMethod($priceCalcMethod);
        $this->beVariant->addSpecialPrice($specialPriceObj);

        $product = new Product();
        $product->setPrice($productPrice);
        $this->beVariant->setProduct($product);

        self::assertSame(
            $expectedBestPrice,
            $this->beVariant->getBestPriceCalculated()
        );
    }

    #[Test]
    public function getStockInitiallyReturnsZero(): void
    {
        self::assertSame(
            0,
            $this->beVariant->getStock()
        );
    }

    #[Test]
    public function setStockSetsStock(): void
    {
        $stock = 10;
        $this->beVariant->setStock($stock);

        self::assertSame(
            $stock,
            $this->beVariant->getStock()
        );
    }

    #[Test]
    public function getIsAvailableInitiallyReturnsFalse(): void
    {
        self::assertFalse(
            $this->beVariant->getIsAvailable()
        );
    }

    #[Test]
    public function getIsAvailableWithStockGreaterZeroReturnsTrue(): void
    {
        $this->beVariant->setStock(10);

        self::assertTrue(
            $this->beVariant->getIsAvailable()
        );
    }
}

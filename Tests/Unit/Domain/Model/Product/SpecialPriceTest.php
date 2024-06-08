<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\SpecialPrice;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class SpecialPriceTest extends UnitTestCase
{
    /**
     * @var SpecialPrice
     */
    protected $specialPrice;

    public function setUp(): void
    {
        $this->specialPrice = new SpecialPrice();
    }

    public function tearDown(): void
    {
        unset($this->specialPrice);
    }

    /**
     * @test
     */
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->specialPrice->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleSetsTitle(): void
    {
        $title = 'Special Price Title';

        $this->specialPrice->setTitle($title);

        self::assertSame(
            $title,
            $this->specialPrice->getTitle()
        );
    }

    /**
     * @test
     */
    public function getPriceInitiallyReturnsZero(): void
    {
        self::assertSame(
            0.0,
            $this->specialPrice->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceSetThePrice(): void
    {
        $price = 1.00;

        $this->specialPrice->setPrice($price);

        self::assertSame(
            $price,
            $this->specialPrice->getPrice()
        );
    }
}

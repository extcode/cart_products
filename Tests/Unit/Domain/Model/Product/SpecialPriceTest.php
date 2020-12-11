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
    public function getTitleInitiallyReturnsEmptyString()
    {
        $this->assertSame(
            '',
            $this->specialPrice->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleSetsTitle()
    {
        $title = 'Special Price Title';

        $this->specialPrice->setTitle($title);

        $this->assertSame(
            $title,
            $this->specialPrice->getTitle()
        );
    }

    /**
     * @test
     */
    public function getPriceInitiallyReturnsZero()
    {
        $this->assertSame(
            0.0,
            $this->specialPrice->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceSetThePrice()
    {
        $price = 1.00;

        $this->specialPrice->setPrice($price);

        $this->assertSame(
            $price,
            $this->specialPrice->getPrice()
        );
    }
}

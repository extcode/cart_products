<?php

namespace Extcode\CartProducts\Tests\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\SpecialPrice;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class SpecialPriceTest extends UnitTestCase
{
    /**
     * Product Special Price
     *
     * @var SpecialPrice
     */
    protected $fixture = null;

    /**
     * Set Up
     */
    public function setUp()
    {
        $this->fixture = new SpecialPrice();
    }

    /**
     * @test
     */
    public function getTitleInitiallyReturnsEmptyString()
    {
        $this->assertSame(
            '',
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleSetsTitle()
    {
        $title = 'Special Price Title';

        $this->fixture->setTitle($title);

        $this->assertSame(
            $title,
            $this->fixture->getTitle()
        );
    }

    /**
     * @test
     */
    public function getPriceInitiallyReturnsZero()
    {
        $this->assertSame(
            0.0,
            $this->fixture->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceSetThePrice()
    {
        $price = 1.00;

        $this->fixture->setPrice($price);

        $this->assertSame(
            $price,
            $this->fixture->getPrice()
        );
    }
}

<?php

namespace Extcode\CartProducts\Tests\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\QuantityDiscount;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class QuantityDiscountTest extends UnitTestCase
{
    /**
     * Product Quantity Discount
     *
     * @var QuantityDiscount
     */
    protected $fixture = null;

    /**
     * Set Up
     */
    public function setUp()
    {
        $this->fixture = new QuantityDiscount();
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

    /**
     * @test
     */
    public function getQuantityInitiallyReturnsZero()
    {
        $this->assertSame(
            0,
            $this->fixture->getQuantity()
        );
    }

    /**
     * @test
     */
    public function setQuantitySetTheQuantity()
    {
        $quantity = 10;

        $this->fixture->setQuantity($quantity);

        $this->assertSame(
            $quantity,
            $this->fixture->getQuantity()
        );
    }
}

<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\QuantityDiscount;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class QuantityDiscountTest extends UnitTestCase
{
    /**
     * @var QuantityDiscount
     */
    protected $quantityDiscount;

    public function setUp(): void
    {
        $this->quantityDiscount = new QuantityDiscount();
    }

    public function tearDown(): void
    {
        unset($this->quantityDiscount);
    }

    /**
     * @test
     */
    public function getPriceInitiallyReturnsZero()
    {
        $this->assertSame(
            0.0,
            $this->quantityDiscount->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceSetThePrice()
    {
        $price = 1.00;

        $this->quantityDiscount->setPrice($price);

        $this->assertSame(
            $price,
            $this->quantityDiscount->getPrice()
        );
    }

    /**
     * @test
     */
    public function getQuantityInitiallyReturnsZero()
    {
        $this->assertSame(
            0,
            $this->quantityDiscount->getQuantity()
        );
    }

    /**
     * @test
     */
    public function setQuantitySetTheQuantity()
    {
        $quantity = 10;

        $this->quantityDiscount->setQuantity($quantity);

        $this->assertSame(
            $quantity,
            $this->quantityDiscount->getQuantity()
        );
    }
}

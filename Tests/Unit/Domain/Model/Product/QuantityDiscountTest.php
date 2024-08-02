<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\QuantityDiscount;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function getPriceInitiallyReturnsZero(): void
    {
        self::assertSame(
            0.0,
            $this->quantityDiscount->getPrice()
        );
    }

    #[Test]
    public function setPriceSetThePrice(): void
    {
        $price = 1.00;

        $this->quantityDiscount->setPrice($price);

        self::assertSame(
            $price,
            $this->quantityDiscount->getPrice()
        );
    }

    #[Test]
    public function getQuantityInitiallyReturnsZero(): void
    {
        self::assertSame(
            0,
            $this->quantityDiscount->getQuantity()
        );
    }

    #[Test]
    public function setQuantitySetTheQuantity(): void
    {
        $quantity = 10;

        $this->quantityDiscount->setQuantity($quantity);

        self::assertSame(
            $quantity,
            $this->quantityDiscount->getQuantity()
        );
    }
}

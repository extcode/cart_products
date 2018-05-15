<?php

namespace Extcode\CartProducts\Tests\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\AbstractProduct;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class AbstractProductTest extends UnitTestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $product = null;

    public function setUp()
    {
        $this->product = $this->getMockForAbstractClass(
            AbstractProduct::class
        );
    }

    /**
     * @test
     */
    public function getSkuReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->product->getSku()
        );
    }

    /**
     * @test
     */
    public function setSkuForStringSetsSku()
    {
        $this->product->setSku('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'sku',
            $this->product
        );
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->product->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->product->setTitle('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->product
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->product->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->product->setDescription('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->product
        );
    }
}

<?php

namespace Extcode\CartProducts\Tests\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\FeVariant;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class FeVariantTest extends UnitTestCase
{
    /**
     * Product Frontend Variant
     *
     * @var FeVariant
     */
    protected $feVariant = null;

    public function setUp()
    {
        $this->feVariant = new FeVariant;
    }

    /**
     * @test
     */
    public function getSkuInitiallyReturnsEmptyString()
    {
        $this->assertSame(
            '',
            $this->feVariant->getSku()
        );
    }

    /**
     * @test
     */
    public function setSkuForStringSetsSku()
    {
        $this->feVariant->setSku('SKU');

        $this->assertSame(
            'SKU',
            $this->feVariant->getSku()
        );
    }

    /**
     * @test
     */
    public function getTitleInitiallyReturnsEmptyString()
    {
        $this->assertSame(
            '',
            $this->feVariant->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->feVariant->setTitle('Title');

        $this->assertSame(
            'Title',
            $this->feVariant->getTitle()
        );
    }

    /**
     * @test
     */
    public function getDescriptionInitiallyReturnsEmptyString()
    {
        $this->assertSame(
            '',
            $this->feVariant->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->feVariant->setDescription('Description');

        $this->assertSame(
            'Description',
            $this->feVariant->getDescription()
        );
    }

    /**
     * @test
     */
    public function getIsRequiredInitiallyReturnsFalse()
    {
        $this->assertFalse(
            $this->feVariant->getIsRequired()
        );
    }

    /**
     * @test
     */
    public function setIsRequiredSetsIsRequired()
    {
        $this->feVariant->setIsRequired(true);

        $this->assertTrue(
            $this->feVariant->getIsRequired()
        );
    }
}

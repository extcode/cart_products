<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\FeVariant;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class FeVariantTest extends UnitTestCase
{
    /**
     * @var FeVariant
     */
    protected $feVariant;

    public function setUp(): void
    {
        $this->feVariant = new FeVariant;
    }

    public function tearDown(): void
    {
        unset($this->feVariant);
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

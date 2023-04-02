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
        $this->feVariant = new FeVariant();
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
        self::assertSame(
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

        self::assertSame(
            'SKU',
            $this->feVariant->getSku()
        );
    }

    /**
     * @test
     */
    public function getTitleInitiallyReturnsEmptyString()
    {
        self::assertSame(
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

        self::assertSame(
            'Title',
            $this->feVariant->getTitle()
        );
    }

    /**
     * @test
     */
    public function getDescriptionInitiallyReturnsEmptyString()
    {
        self::assertSame(
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

        self::assertSame(
            'Description',
            $this->feVariant->getDescription()
        );
    }

    /**
     * @test
     */
    public function getIsRequiredInitiallyReturnsFalse()
    {
        self::assertFalse(
            $this->feVariant->getIsRequired()
        );
    }

    /**
     * @test
     */
    public function setIsRequiredSetsIsRequired()
    {
        $this->feVariant->setIsRequired(true);

        self::assertTrue(
            $this->feVariant->getIsRequired()
        );
    }
}

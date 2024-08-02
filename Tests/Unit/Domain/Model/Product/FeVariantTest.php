<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\FeVariant;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function getSkuInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->feVariant->getSku()
        );
    }

    #[Test]
    public function setSkuForStringSetsSku(): void
    {
        $this->feVariant->setSku('SKU');

        self::assertSame(
            'SKU',
            $this->feVariant->getSku()
        );
    }

    #[Test]
    public function getTitleInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->feVariant->getTitle()
        );
    }

    #[Test]
    public function setTitleForStringSetsTitle(): void
    {
        $this->feVariant->setTitle('Title');

        self::assertSame(
            'Title',
            $this->feVariant->getTitle()
        );
    }

    #[Test]
    public function getDescriptionInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->feVariant->getDescription()
        );
    }

    #[Test]
    public function setDescriptionForStringSetsDescription(): void
    {
        $this->feVariant->setDescription('Description');

        self::assertSame(
            'Description',
            $this->feVariant->getDescription()
        );
    }

    #[Test]
    public function getIsRequiredInitiallyReturnsFalse(): void
    {
        self::assertFalse(
            $this->feVariant->getIsRequired()
        );
    }

    #[Test]
    public function setIsRequiredSetsIsRequired(): void
    {
        $this->feVariant->setIsRequired(true);

        self::assertTrue(
            $this->feVariant->getIsRequired()
        );
    }
}

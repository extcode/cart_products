<?php

namespace Extcode\CartProducts\Tests\Unit\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute;
use Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class BeVariantAttributeTest extends UnitTestCase
{
    /**
     * @var BeVariantAttribute
     */
    protected $beVariantAttribute;

    public function setUp(): void
    {
        $this->beVariantAttribute = new BeVariantAttribute();
    }

    public function tearDown(): void
    {
        unset($this->beVariantAttribute);
    }

    /**
     * @test
     */
    public function getBeVariantAttributeOptionsInitiallyIsEmpty(): void
    {
        self::assertEmpty(
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }

    /**
     * @test
     */
    public function setTransactionsSetsTransactions(): void
    {
        $beVariantAttributeOption1 = new BeVariantAttributeOption();
        $beVariantAttributeOption2 = new BeVariantAttributeOption();

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($beVariantAttributeOption1);
        $objectStorage->attach($beVariantAttributeOption2);

        $this->beVariantAttribute->setBeVariantAttributeOptions($objectStorage);

        self::assertContains(
            $beVariantAttributeOption1,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
        self::assertContains(
            $beVariantAttributeOption2,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }

    /**
     * @test
     */
    public function addTransactionAddsTransaction(): void
    {
        $beVariantAttributeOption1 = new BeVariantAttributeOption();
        $beVariantAttributeOption2 = new BeVariantAttributeOption();

        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption1);
        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption2);

        self::assertContains(
            $beVariantAttributeOption1,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
        self::assertContains(
            $beVariantAttributeOption2,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }

    /**
     * @test
     */
    public function removeTransactionRemovesTransaction(): void
    {
        $beVariantAttributeOption1 = new BeVariantAttributeOption();
        $beVariantAttributeOption2 = new BeVariantAttributeOption();

        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption1);
        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption2);
        $this->beVariantAttribute->removeBeVariantAttributeOption($beVariantAttributeOption1);

        self::assertNotContains(
            $beVariantAttributeOption1,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
        self::assertContains(
            $beVariantAttributeOption2,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }
}

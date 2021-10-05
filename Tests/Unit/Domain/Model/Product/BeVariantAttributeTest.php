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
    public function getBeVariantAttributeOptionsInitiallyIsEmpty()
    {
        $this->assertEmpty(
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }

    /**
     * @test
     */
    public function setTransactionsSetsTransactions()
    {
        $beVariantAttributeOption1 = new BeVariantAttributeOption();
        $beVariantAttributeOption2 = new BeVariantAttributeOption();

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($beVariantAttributeOption1);
        $objectStorage->attach($beVariantAttributeOption2);

        $this->beVariantAttribute->setBeVariantAttributeOptions($objectStorage);

        $this->assertContains(
            $beVariantAttributeOption1,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
        $this->assertContains(
            $beVariantAttributeOption2,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }

    /**
     * @test
     */
    public function addTransactionAddsTransaction()
    {
        $beVariantAttributeOption1 = new BeVariantAttributeOption();
        $beVariantAttributeOption2 = new BeVariantAttributeOption();

        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption1);
        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption2);

        $this->assertContains(
            $beVariantAttributeOption1,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
        $this->assertContains(
            $beVariantAttributeOption2,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }

    /**
     * @test
     */
    public function removeTransactionRemovesTransaction()
    {
        $beVariantAttributeOption1 = new BeVariantAttributeOption();
        $beVariantAttributeOption2 = new BeVariantAttributeOption();

        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption1);
        $this->beVariantAttribute->addBeVariantAttributeOption($beVariantAttributeOption2);
        $this->beVariantAttribute->removeBeVariantAttributeOption($beVariantAttributeOption1);

        $this->assertNotContains(
            $beVariantAttributeOption1,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
        $this->assertContains(
            $beVariantAttributeOption2,
            $this->beVariantAttribute->getBeVariantAttributeOptions()
        );
    }
}

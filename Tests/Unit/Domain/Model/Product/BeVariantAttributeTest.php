<?php

namespace Extcode\CartProducts\Tests\Domain\Model\Product;

use Extcode\CartProducts\Domain\Model\Product\BeVariantAttribute;
use Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class BeVariantAttributeTest extends UnitTestCase
{
    /**
     * @var BeVariantAttribute
     */
    protected $beVariantAttribute = null;

    /**
     *
     */
    public function setUp()
    {
        $this->beVariantAttribute = new BeVariantAttribute();
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

        $objectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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

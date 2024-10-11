<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

trait ProductBackendVariantTrait
{
    protected ?BeVariantAttribute $beVariantAttribute1 = null;

    protected ?BeVariantAttribute $beVariantAttribute2 = null;

    protected ?BeVariantAttribute $beVariantAttribute3 = null;

    /**
     * @var ObjectStorage<BeVariant>
     */
    #[Cascade(['value' => 'remove'])]
    protected ObjectStorage $beVariants;

    public function getBeVariantAttribute1(): ?BeVariantAttribute
    {
        return $this->beVariantAttribute1;
    }

    public function setBeVariantAttribute1(BeVariantAttribute $beVariantAttribute1): void
    {
        $this->beVariantAttribute1 = $beVariantAttribute1;
    }

    public function getBeVariantAttribute2(): ?BeVariantAttribute
    {
        return $this->beVariantAttribute2;
    }

    public function setBeVariantAttribute2(BeVariantAttribute $beVariantAttribute2): void
    {
        $this->beVariantAttribute2 = $beVariantAttribute2;
    }

    public function getBeVariantAttribute3(): ?BeVariantAttribute
    {
        return $this->beVariantAttribute3;
    }

    public function setBeVariantAttribute3(BeVariantAttribute $beVariantAttribute3): void
    {
        $this->beVariantAttribute3 = $beVariantAttribute3;
    }

    public function addBeVariant(BeVariant $beVariant): void
    {
        $this->beVariants->attach($beVariant);
    }

    public function removeBeVariant(BeVariant $beVariant): void
    {
        $this->beVariants->detach($beVariant);
    }

    /**
     * @return ObjectStorage<BeVariant>
     */
    public function getBeVariants(): ?ObjectStorage
    {
        return $this->beVariants;
    }

    /**
     * @param ObjectStorage<BeVariant> $beVariants
     */
    public function setBeVariants(ObjectStorage $beVariants): void
    {
        $this->beVariants = $beVariants;
    }
}

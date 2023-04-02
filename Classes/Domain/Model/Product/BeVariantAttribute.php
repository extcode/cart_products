<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\Cart\Domain\Model\Product\AbstractProduct;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class BeVariantAttribute extends AbstractProduct
{
    /**
     * @var ObjectStorage<BeVariantAttributeOption>
     */
    protected ObjectStorage $beVariantAttributeOptions;

    public function __construct()
    {
        $this->initStorageObjects();
    }

    protected function initStorageObjects(): void
    {
        $this->beVariantAttributeOptions = new ObjectStorage();
    }

    public function addBeVariantAttributeOption(BeVariantAttributeOption $beVariantAttributeOption): void
    {
        $this->beVariantAttributeOptions->attach($beVariantAttributeOption);
    }

    public function removeBeVariantAttributeOption(BeVariantAttributeOption $beVariantAttributeOption): void
    {
        $this->beVariantAttributeOptions->detach($beVariantAttributeOption);
    }

    public function getBeVariantAttributeOptions(): ObjectStorage
    {
        return $this->beVariantAttributeOptions;
    }

    public function setBeVariantAttributeOptions(ObjectStorage $beVariantAttributeOptions): void
    {
        $this->beVariantAttributeOptions = $beVariantAttributeOptions;
    }
}

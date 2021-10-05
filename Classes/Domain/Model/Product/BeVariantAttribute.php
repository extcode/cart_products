<?php

namespace Extcode\CartProducts\Domain\Model\Product;

/*
 * This file is part of the package extcode/cart-products.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Extcode\CartProducts\Domain\Model\Product;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class BeVariantAttribute extends AbstractProduct
{
    /**
     * BeVariantAttributeOptions
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption>
     */
    protected $beVariantAttributeOptions = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->initStorageObjects();
    }

    /**
     * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
     */
    protected function initStorageObjects()
    {
        $this->beVariantAttributeOptions = new ObjectStorage();
    }

    /**
     * Adds BeVariantAttributeOption
     *
     * @param Product\BeVariantAttributeOption $beVariantAttributeOption
     */
    public function addBeVariantAttributeOption(
        BeVariantAttributeOption $beVariantAttributeOption
    ) {
        $this->beVariantAttributeOptions->attach($beVariantAttributeOption);
    }

    /**
     * Removes BeVariantAttributeOption
     *
     * @param Product\BeVariantAttributeOption $beVariantAttributeOption
     */
    public function removeBeVariantAttributeOption(
        BeVariantAttributeOption $beVariantAttributeOption
    ) {
        $this->beVariantAttributeOptions->detach($beVariantAttributeOption);
    }

    /**
     * Returns BeVariantAttributeOptions
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Extcode\CartProducts\Domain\Model\Product\BeVariantAttributeOption>
     */
    public function getBeVariantAttributeOptions()
    {
        return $this->beVariantAttributeOptions;
    }

    /**
     * Sets BeVariantAttributeOptions
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $beVariantAttributeOptions
     */
    public function setBeVariantAttributeOptions(
        ObjectStorage $beVariantAttributeOptions
    ) {
        $this->beVariantAttributeOptions = $beVariantAttributeOptions;
    }
}
